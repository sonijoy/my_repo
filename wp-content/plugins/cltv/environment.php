<?php

  // Define this in wp-config.php
  if (!defined('WP_ENV')) {
    define('WP_ENV', 'production');
  }

  $s3 = array(
    'development' => array(
      'bucket' => 'cltv-archives-dev',
      'dir' => '',
      'guid_prefix' => 'http://recordingsdev.citylinktv.com/'
    ),
    'production' => array(
      'bucket' => 'cltv-archives',
      'dir' => '',
      'guid_prefix' => 'http://recordings.citylinktv.com/'
    )
  );

  $aws = array(
    'key'    => 'AKIAIH3MCUF7CW2LMQ6Q',
    'secret' => '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',
    's3' => $s3[WP_ENV]
  );

  return array(
    'aws' => $aws
  );

?>
