<?php
require_once(get_template_directory().'/library/aws-sdk-php/vendor/autoload.php');
use Aws\Common\Aws;

// endpoint for the aws cores ajax call by fineuploader
add_action("init","s3_uploader_init");

// enqueue javascript files for fine uploader
add_action("admin_init","s3_uploader_admin_init");

// setup javascript vars
add_action('admin_head','s3_uploader_js_vars');

// catch all requests to /s3_uploader_cors
add_action("template_redirect", "s3_uploader_awscors");

// create an attachment on post success
add_action( 'wp_ajax_s3_uploader_success', 's3_uploader_success' );

// delete files from s3
add_action("before_delete_post","s3_uploader_delete");

// register the ACF field
add_action('acf/register_fields', 's3_uploader_register_fields');

// catch query vars
add_filter("request", "s3_uploader_awscors_request" );

// endpoint for the aws cores ajax call by fineuploader
// action: init
function s3_uploader_init(){
	add_rewrite_endpoint( "s3_uploader_cors", EP_PERMALINK );
}

// enqueue javascript files for fine uploader
// action: admin_init
function s3_uploader_admin_init(){
	wp_register_script("fineuploader", plugins_url( '/js/s3.jquery.fineuploader-5.0.8.min.js', __FILE__ ), array( 'jquery' ) );
	wp_register_script("init-fineuploader", plugins_url( '/js/init-fineuploader.js', __FILE__ ) );
	wp_register_style("fineuploader", plugins_url( '/css/fineuploader-5.0.8.min.css', __FILE__ ) );

	wp_enqueue_script("fineuploader");
	wp_enqueue_style("fineuploader");
	wp_enqueue_script("init-fineuploader");
}

// setup javascript vars
// action: admin_head
function s3_uploader_js_vars() {
	$aws = include(get_template_directory() . "/library/aws-config.php");
	?>
	<script type="text/javascript">
		var aws_access_key = '<?=$aws['services']['default_settings']['params']['key']; ?>';  //'AKIAJIE27CTN5NUSK3VQ';
		var aws_archive_bucket = 'cltv-archives';
	</script>
	<?php
}

// catch all requests to /s3_uploader_cors
// action: template_redirect
function s3_uploader_awscors(){
  global $wp_query;
  if ( ! isset( $wp_query->query_vars['s3_uploader_cors'] ) ){
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

// on upload success
// action: wp_ajax_s3_uploader_success
function s3_uploader_success(){
	// TODO: see if the archive already has a video file, if it does delete it from S3 and then add the new file

	$file = $_POST['key'];
	$guid = "https://" . $_POST['bucket'] . ".s3.amazonaws.com/" . $_POST['key'];
	$post_id = $_POST['post_id'];
	$attachment = array(
			'guid' => $guid,
			'post_title' => preg_replace('/\.[^.]+$/', '', $file),
			'post_content' => '',
			'post_status' => 'inherit',
			'post_parent' => $post_id
	);
	$attach_id = wp_insert_attachment($attachment, $file, $post_id);
	update_post_meta($attach_id, 'key', $_POST['key']);
	update_post_meta($post_id, 's3_file', $attach_id);

	exit;
}

// delete files from s3
// action: before_delete_post
function s3_uploader_delete($post_id){
  $s3_attach_id = get_post_meta($post_id,"s3_file",true);

	if ( $s3_attach_id ){
		$s3_file_key = get_post_meta($s3_attach_id,"key",true);
		if ( $s3_file_key != "" ){
			$aws = Aws::factory(get_template_directory().'/library/aws-config.php');
			$client = $aws->get('s3');
			$deleted = $client->deleteObject(array(
					'Bucket' => S3_BUCKET,
					'Key'    => $s3_file_key
			));
		}
	}
}

// catch query vars
// filter: request
function s3_uploader_awscors_request ( $vars ) {
	( $vars['name'] == "s3_uploader_cors" ) and $vars['s3_uploader_cors'] = true;
	return $vars;
}

// Register custom fields
// action: acf/register_fields
function s3_uploader_register_fields()
{
	include_once('s3-uploader.php');
}

?>
