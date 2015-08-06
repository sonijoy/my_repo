<?php
/*
Template Name: Video API
*/

$result = array();

// Makes sure we have an action
if(isset($_GET['action'])) {
  $action = $_GET['action'];
}
else {
  $result['success'] = 'false';
  $result['message'] = 'No action param provided';
  echo json_encode($result);
  die();
}

switch($action) {
  case 'validateStreamKey':
    echo cltv_validate_stream_key();
    break;
  default:
    echo '';
}

function cltv_validate_stream_key() {
  $result = array();

  // Makes sure we have a key
  if(isset($_GET['key'])) {
    $key = $_GET['key'];
  }
  else {
    $result['success'] = 'false';
    $result['message'] = 'No key param provided';
    return json_encode($result);
  }

  // search for a channel with the key
  $query_args = array(
    'post_type' => 'channel',
    'meta_key' => 'stream_key',
    'meta_value' => $key
  );
  $query = new WP_Query($query_args);

  // if we found a channel, it's valid
  if($query->post_count) {
    $result['success'] = 'true';
    $result['isValid'] = 'true';
  }
  else {
    $result['success'] = 'true';
    $result['isValid'] = 'false';
  }

  // return the json
  return json_encode($result);
}
