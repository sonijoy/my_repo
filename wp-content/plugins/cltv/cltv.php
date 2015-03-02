<?php
/**
 * Plugin Name: CLTV
 * Plugin URI:
 * Description: CLTV Functionality
 * Version: 1.0
 * Author: Josh Fester & Brandon Bohannon
 * Author URI: http://www.citylinktv.com/
 * License: Proprietary
 */

// AWS config and Environment
require_once(dirname(__File__).'/vendor/aws-sdk-php/vendor/autoload.php');
$environment = require_once(dirname(__File__).'/environment.php');

//include("update_live_status.php");

// post types
require_once(dirname(__File__)."/post-types/archive.php");
require_once(dirname(__File__)."/post-types/channel.php");
require_once(dirname(__File__)."/post-types/commercial.php");
require_once(dirname(__File__)."/post-types/sponsor.php");

// ACF fields
add_action('acf/register_fields', 'my_register_fields');
function my_register_fields()
{
	include_once(dirname(__File__).'/acf-fields/channel-stream-key.php');
	include_once(dirname(__File__).'/acf-fields/channel-rtmp-url.php');
	include_once(dirname(__File__).'/acf-fields/channel-embed-code.php');
  require_once(dirname(__File__)."/acf-fields/s3-uploader/bootstrap.php");
}

// wp-admin customization
require_once(dirname(__File__).'/admin.php');

// AJAX functions
require_once(dirname(__File__).'/ajax-functions.php');


// Template helpers
require_once(dirname(__File__)."/helpers.php");

?>
