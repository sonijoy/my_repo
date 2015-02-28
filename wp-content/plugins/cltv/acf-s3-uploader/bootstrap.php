<?php

add_action("template_redirect", "cltv_fineuploader_awscores");
function cltv_fineuploader_awscores(){
  global $wp_query;
  if ( ! isset( $wp_query->query_vars['cltv_aws_cores'] ) ){
    return;
  }
  $aws = include(get_template_directory() . "/library/aws-config.php");

  $request_body = file_get_contents('php://input');

  $policy_fixed = str_replace(array("\n","\r\n"),"",$request_body);

  $retVal = array();
  $retVal['policy'] = base64_encode($policy_fixed);
  $retVal['signature'] = base64_encode(hash_hmac( 'sha1', base64_encode(utf8_encode($policy_fixed)), $aws['services']['default_settings']['params']['secret'],true));

  echo json_encode($retVal);
  exit;
}

?>
