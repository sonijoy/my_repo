<?php
require_once(get_template_directory().'/library/aws-sdk-php/vendor/autoload.php');
use Aws\Common\Aws;

// enqueue javascript files for fine uploader
add_action("init","cltv_archive_init");
add_action("admin_init","cltv_archive_admin_init");
add_action("template_redirect", "cltv_fineuploader_awscores");
add_action( 'wp_ajax_cltv_archive_upload_success', 'cltv_archive_upload_success' );

add_action("before_delete_post","cltv_delete_archive");

add_filter("request", "cltv_fineuploader_awscores_request" );

function cltv_fineuploader_awscores_request ( $vars ) {
	( $vars['name'] == "cltv_aws_cores" ) and $vars['cltv_aws_cores'] = true;
	return $vars;
}

function cltv_archive_admin_init(){
	// enqueue the fine uploader scripts only when on the dashboard
	wp_register_script("fineuploader", plugins_url( '/js/s3.jquery.fineuploader-5.0.8.min.js', __FILE__ ), array( 'jquery' ) );
	wp_register_script("init-fineuploader", plugins_url( '/js/init-fineuploader.js', __FILE__ ) );
	wp_register_style("fineuploader", plugins_url( '/css/fineuploader-5.0.8.min.css', __FILE__ ) );

	wp_enqueue_script("fineuploader");
	wp_enqueue_style("fineuploader");
	wp_enqueue_script("init-fineuploader");
}

function cltv_archive_init(){
	add_rewrite_endpoint( "cltv_aws_cores", EP_PERMALINK ); // endpoint for the aws cores ajax call by fineuploader
}

// Archive post type and all things associated with it
function custom_post_archive_init() {

	register_post_type( 'archive', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		array('labels' => array(
			'name' => __('Archives'), /* This is the Title of the Group */
			'singular_name' => __('Archive'), /* This is the individual type */
			'all_items' => __('All Archives'), /* the all items menu item */
			'add_new' => __('Add New'), /* The add new menu item */
			'add_new_item' => __('Add New Archive'), /* Add New Display Title */
			'edit' => __( 'Edit' ), /* Edit Dialog */
			'edit_item' => __('Edit Archive'), /* Edit Display Title */
			'new_item' => __('New Archive'), /* New Display Title */
			'view_item' => __('View Archive'), /* View Display Title */
			'search_items' => __('Search Archive'), /* Search Custom Type Title */
			'not_found' =>  __('Nothing found in the Database.'), /* This displays if there are no entries yet */
			'not_found_in_trash' => __('Nothing found in Trash'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( '' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
			'menu_icon' => 'dashicons-media-video', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'archive', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'archive', /* you can rename the slug here */
			'capability_type' => 'archive',
			'hierarchical' => false,
			'supports' => array( 'title', 'author', 'thumbnail'),
			'map_meta_cap' => true,
			'register_meta_box_cb' => 'cltv_archive_metaboxes'
	 	) /* end of options */
	); /* end of register post type */
}
add_action( 'init', 'custom_post_archive_init');

function cltv_archive_metaboxes(){
	add_meta_box('cltv_archives_file', 'Video File', 'cltv_archive_video_upload_html', 'archive', 'normal', 'high');
}

function cltv_archive_video_upload_html( $post ){

	$video_attach_id = get_post_meta($post->ID,"video_file",true);
	$video = wp_get_attachment_url($video_attach_id);

echo "<div id=\"fine-uploader\"></div>";
echo "<div id=\"file-name\">Video: " . $video . "</div>";
echo <<<FU_TEMPLATE
	<script type="text/template" id="qq-template">
        <div class="qq-uploader-selector qq-uploader">
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span>Drop files here to upload</span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button">
                <div>Upload a file</div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list">
                <li>
                  <div class="qq-progress-bar-container-selector">
                      <div class="qq-progress-bar-selector qq-progress-bar"></div>
                  </div>
                  <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                  <span class="qq-edit-filename-icon-selector qq-edit-filename-icon"></span>
                  <span class="qq-upload-file-selector qq-upload-file"></span>
                  <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                  <span class="qq-upload-size-selector qq-upload-size"></span>
                  <a class="qq-upload-cancel-selector qq-upload-cancel" href="#">Cancel</a>
                  <a class="qq-upload-retry-selector qq-upload-retry" href="#">Retry</a>
                  <a class="qq-upload-delete-selector qq-upload-delete" href="#">Delete</a>
                  <span class="qq-upload-status-text-selector qq-upload-status-text"></span>
              </li>
            </ul>
        </div>
    </script>
FU_TEMPLATE;
}

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

function cltv_archive_upload_success(){

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
	update_post_meta($post_id, 'video_file', $attach_id);
	update_post_meta($attach_id, 'recorded', true);

	exit;
}

function cltv_delete_archive($post_id){
	// when an archive is deleted, delete the video file from S3
	if ( get_post_type($post_id) == "archive" ){
		$video_attach_id = get_post_meta($post_id,"video_file",true);
		$s3_file_key = get_post_meta($video_attach_id,"key",true);
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

?>