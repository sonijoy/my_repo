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
// S3 uploader should probably be a separate plugin
require_once(dirname(__File__)."/acf-fields/s3-uploader/bootstrap.php");
add_action('acf/include_field_types', 'cltv_include_field_types');
function cltv_include_field_types()
{
  require_once(dirname(__File__).'/acf-fields/acf-channel_embed_code.php');
}

// wp-admin customization
require_once(dirname(__File__).'/admin.php');

// AJAX functions
require_once(dirname(__File__).'/ajax-functions.php');


// Template helpers
require_once(dirname(__File__)."/helpers.php");

?>
