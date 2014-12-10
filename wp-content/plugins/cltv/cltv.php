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
include("update_live_status.php");
include("archive-post-type.php");

function cltv_awsvariables_for_javascript() {
	$aws = include(get_template_directory() . "/library/aws-config.php");
	?>
	<script type="text/javascript">
		var aws_access_key = '<?=$aws['services']['default_settings']['params']['key']; ?>';  //'AKIAJIE27CTN5NUSK3VQ';
		var aws_bucket = '<?=S3_BUCKET; ?>';
	</script>
	<?php
}
add_action('admin_head','cltv_awsvariables_for_javascript');

?>