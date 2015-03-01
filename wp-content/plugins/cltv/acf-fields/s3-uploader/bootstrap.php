<?php
require_once(get_template_directory().'/library/aws-sdk-php/vendor/autoload.php');
use Aws\S3\S3Client;
use Aws\Common\Credentials\Credentials;

$environment = require_once(dirname(__File__).'/../../environment.php');

// endpoint for the aws cors ajax call by fineuploader
add_action("init", "s3_uploader_init");

// enqueue javascript files for fine uploader
add_action("admin_init", "s3_uploader_admin_init");

// setup javascript vars
add_action('admin_head', 's3_uploader_js_vars');

// catch all requests to /s3_uploader_cors
add_action("template_redirect", "s3_uploader_awscors");

// create an attachment on post success
add_action( 'wp_ajax_s3_uploader_success', 's3_uploader_success' );

// delete attachments from post
add_action("before_delete_post","s3_uploader_delete_post");

// delete files from s3
add_action("delete_attachment","s3_uploader_delete_attachment");

// register the ACF field
add_action('acf/register_fields', 's3_uploader_register_fields');

// catch query vars
add_filter("request", "s3_uploader_awscors_request" );

// endpoint for the aws cors ajax call by fineuploader
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
	global $environment;
	?>
	<script type="text/javascript">
		var s3_uploader_access_key = '<?=$environment['aws']['key']; ?>';  //'AKIAJIE27CTN5NUSK3VQ';
		var s3_uploader_bucket = '<?=$environment['aws']['s3']['bucket']; ?>';
	</script>
	<?php
}

// catch all requests to /s3_uploader_cors
// action: template_redirect
function s3_uploader_awscors(){
  global $wp_query;
	global $environment;
  if ( ! isset( $wp_query->query_vars['s3_uploader_cors'] ) ){
    return;
  }

	header("HTTP/1.1 200 OK");

  $request_body = file_get_contents('php://input');

  $policy_fixed = str_replace(array("\n","\r\n"),"",$request_body);

  $retVal = array();
  $retVal['policy'] = base64_encode($policy_fixed);
  $retVal['signature'] = base64_encode(hash_hmac( 'sha1', base64_encode(utf8_encode($policy_fixed)), $environment['aws']['secret'],true));

  echo json_encode($retVal);
  exit;
}

// on upload success
// action: wp_ajax_s3_uploader_success
function s3_uploader_success(){
	// TODO: see if the archive already has a video file, if it does delete it from S3 and then add the new file

	$file = $_POST['key'];
	$field = $_POST['acf_name'];
	$guid = "https://" . $_POST['bucket'] . ".s3.amazonaws.com/" . $_POST['key'];
	$post_id = $_POST['post_id'];
	$attachment = array(
			'guid' => $guid,
			'post_title' => preg_replace('/\.[^.]+$/', '', $file),
			'post_content' => '',
			'post_status' => 'inherit',
			'post_parent' => $post_id
	);

	// create the attachment
	$attach_id = wp_insert_attachment($attachment, $file, $post_id);

	// set the filename on the attachment
	update_post_meta($attach_id, 's3_uploader_key', $file);

	// set the ACF field on the post using the attachment ID
	update_post_meta($post_id, $field, $attach_id);

	exit;
}

// delete attachments from post
// action: before_delete_post
function s3_uploader_delete_post($post_id){
	$attachments = get_children(array(
		'post_parent' => $post_id,
		'post_type'   => 'attachment',
		'numberposts' => -1,
		'post_status' => 'any'
	));

	foreach($attachments as $attachment) {
		wp_delete_attachment($attachment->ID);
	}
}

// delete files from s3
// action: delete_attachment
function s3_uploader_delete_attachment($post_id){
	global $environment;
	$key = get_post_meta($post_id,"s3_uploader_key",true);

	if ( $key && $key != '' ){
		$credentials = new Credentials($environment['aws']['key'], $environment['aws']['secret']);
		$s3Client = S3Client::factory(array(
		    'credentials' => $credentials
		));
		$deleted = $s3Client->deleteObject(array(
				'Bucket' => $environment['aws']['s3']['bucket'],
				'Key'    => $key
		));
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
