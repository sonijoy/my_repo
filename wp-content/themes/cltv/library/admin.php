<?php

/* ------------------------------------------------------------------
|
|
|	Login/Logout
|
|
| ------------------------------------------------------------------- */

// Redirect after login
function change_login_redirect( $redirect_to, $request, $user ){
    //is there a user to check?
    if( isset($user->roles) && is_array( $user->roles ) ) {
        if( in_array( "administrator", $user->roles ) || $user->ID = 233 ) {
            // redirect them to the default place
            return admin_url('index.php');
        } elseif( in_array( "channel", $user->roles ) ) {
			// redirect them to either their channel or the new channel page
			$channel_q = new WP_Query(array('post_type' => 'channel', 'author' => $user->ID, 'posts_per_page'=>1));
			if($channel_q->have_posts()){
				return admin_url('index.php');
			} else {
				return admin_url('post-new.php?post_type=channel');
			}			
		} else {
            return admin_url();
        }
    }
}
add_filter("login_redirect", "change_login_redirect", 10, 3);

// Redirect after logout 
function change_logout_redirect($logouturl, $redir)
{
	$redir = home_url();
	return $logouturl . '&amp;redirect_to=' . urlencode($redir);
}
add_filter('logout_url', 'change_logout_redirect', 10, 2);

// Change the login logo
function change_login_logo() { ?>
    <style type="text/css">
		
		body.login div#login {
            padding-top:30px;
        }
        body.login div#login h1 a {
            background-image: url(<?php echo get_bloginfo( 'template_directory' ) ?>/images/logo-login.png);
            padding-bottom: 30px;
            background-size:auto;
            height:238px;
            width:auto;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'change_login_logo' );

/* ------------------------------------------------------------------
|
|
|	Admin Style
|
|
| -------------------------------------------------------------------*/

// Custom CSS, JS, and Navbar
function my_admin_head() {
	/*wp_enqueue_style( 'bootstrap_admin_css', get_template_directory_uri() . '/library/css/bootstrap.admin.min.css' );
	wp_enqueue_style( 'bootstrap-responsive', '//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-responsive.min.css' );	
	wp_enqueue_style( 'mCustomScrollbar', get_template_directory_uri() . '/library/css/jquery.mCustomScrollbar.css' );
	wp_enqueue_style( 'style_css', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/library/css/admin.css' );*/
	if(current_user_can('channel')){
		wp_enqueue_style( 'admin_channel_css', get_template_directory_uri() . '/library/css/admin.channel.css' );
	}
	
	/*wp_register_script('bootstrap_admin_js', get_template_directory_uri().'/library/js/bootstrap.admin.min.js');
	wp_register_script('modernizr', get_template_directory_uri().'/library/js/modernizr.full.min.js');
	wp_register_script('jquery-mousewheel', get_template_directory_uri().'/library/js/jquery.mousewheel.min.js');
	wp_register_script('mCustomScrollbar', get_template_directory_uri().'/library/js/jquery.mCustomScrollbar.min.js');
	wp_register_script('custom', get_template_directory_uri().'/library/js/custom.js');*/
	wp_register_script('admin_js', get_template_directory_uri().'/library/js/admin.js');
	
	/*wp_enqueue_script('bootstrap_admin_js', array('jQuery'), '1.1', true);
	wp_enqueue_script('modernizr', array('jQuery'), '1.1', true);
	wp_enqueue_script('jquery-mousewheel', array('jQuery'), '1.1', true);
	wp_enqueue_script('mCustomScrollbar', array('jQuery'), '1.1', true);
	wp_enqueue_script('custom', array('jQuery'), '1.1', true);*/
	wp_enqueue_script('admin_js', array('jQuery'), '1.11', true);
}
add_action('admin_enqueue_scripts', 'my_admin_head');

// Add the header and some ie8 css (blah)
function my_adminmenu() {
	?>
	<!--[if lt IE 9]>
		<style type="text/css">
			html body { margin-top:65px; }
		</style>
	<![endif]-->
	<script type="text/html" id="header_navbar_php">
	<?php
		require_once(TEMPLATEPATH.'/header-navbar.php');
	?>
	</script>
	<?php
}
//add_action('adminmenu', 'my_adminmenu');


/* ------------------------------------------------------------------
|
|
|	Alter the meta boxes for custom post types
|
|
| -------------------------------------------------------------------*/

// Change the label of the "Publish" meta box for channel owners
function change_publish_label(){
	remove_meta_box( 'submitdiv', 'channel', 'normal' );
	add_meta_box( 'submitdiv', __( 'Save Settings' ), 'post_submit_meta_box', 'channel', 'side', 'high' );
	remove_meta_box( 'submitdiv', 'archive', 'normal' );
	add_meta_box( 'submitdiv', __( 'Save Archive' ), 'post_submit_meta_box', 'archive', 'side', 'high' );
	remove_meta_box( 'submitdiv', 'sponsor', 'normal' );
	add_meta_box( 'submitdiv', __( 'Save Sponsor' ), 'post_submit_meta_box', 'sponsor', 'side', 'high' );
}
add_action( 'do_meta_boxes',  'change_publish_label' );

// Change the featured image label
function change_image_box()
{
    remove_meta_box( 'postimagediv', 'channel', 'side' );
    add_meta_box('postimagediv', __('Logo'), 'post_thumbnail_meta_box', 'channel', 'side', 'high');
	remove_meta_box( 'postimagediv', 'archive', 'side' );
    add_meta_box('postimagediv', __('Thumbnail'), 'post_thumbnail_meta_box', 'archive', 'side', 'high');
	remove_meta_box( 'postimagediv', 'sponsor', 'side' );
    add_meta_box('postimagediv', __('Logo'), 'post_thumbnail_meta_box', 'sponsor', 'side', 'high');
}
add_action('do_meta_boxes', 'change_image_box');

// Remove the channel category box for channel_owner
function remove_channel_cat_meta() {
	remove_meta_box( 'channel_catdiv', 'channel', 'side');
	remove_meta_box( 'tribe_events_catdiv', 'tribe_events', 'side');
	remove_meta_box( 'postexcerpt', 'tribe_events', 'normal' );
	remove_meta_box( 'postcustom', 'tribe_events', 'normal' );
	remove_meta_box( 'authordiv', 'tribe_events', 'normal' );
}
add_action( 'admin_menu' , 'remove_channel_cat_meta' );

// Add columns showing video status
function custom_archive_columns($column_name, $id){
	$attachment_id = get_post_meta($id, 'video_file', true);
	$status = get_post_meta($attachment_id, 'mtc_status', true);
	switch ($column_name) {
	    case 'status':
			if(empty($attachment_id)){
				echo 'No file selected';
			} else echo 'Complete'; 
	        break;
	    default:
	        break;
    } // end switch
}
function archive_columns($columns) {
	$new_columns = array(
		'status' => 'Status'
	);
    return array_merge($columns, $new_columns);
}
add_action('manage_archive_posts_custom_column', 'custom_archive_columns', 10, 2);
add_filter('manage_archive_posts_columns' , 'archive_columns', 10, 1);

/* ------------------------------------------------------------------
|
|
|	Navigation
|
|
| -------------------------------------------------------------------*/

// Hide admin bar 
show_admin_bar(false);
remove_action( 'init', '_wp_admin_bar_init' ); 

// Hide the screen options
add_filter('screen_options_show_screen', '__return_false'); 

// Remove the media tab for channel_owner
function remove_dashboard(){
	if (!current_user_can('administrator')) {
		remove_menu_page('upload.php');
	}
}
add_action( 'admin_menu', 'remove_dashboard' );  


//Remove submenu items
function remove_submenu_items() {
  $page = remove_submenu_page( 'edit.php?post_type=tribe_events', 'edit-tags.php?taxonomy=tribe_events_cat&amp;post_type=tribe_events' );
}
add_action( 'admin_menu', 'remove_submenu_items' );

// Hide the color schemes from profile
function hide_color_scheme() {
   global $_wp_admin_css_colors;
   $_wp_admin_css_colors = 0;
}
add_action('admin_head', 'hide_color_scheme');

// Add user's chann
function add_channels_submenu() {
	if(current_user_can('channel')){
		global $current_user;
		global $post; 
		$original = $post;
		$channel_q = new WP_Query(array('post_type' => 'channel', 'author' => $current_user->ID));
		while($channel_q->have_posts()) {
			$channel_q->the_post();
			add_submenu_page('edit.php?post_type=channel', get_the_title(), get_the_title(), 'edit_channels', 'post.php?action=edit&post='.get_the_ID());
		}
		$post = $original; 
		wp_reset_postdata();
	}
}
add_action('admin_menu', 'add_channels_submenu');

// Show a notice if user has no email
function admin_notice_email(){
	echo '<div class="updated">
	   <p>Please go to your <a href="/wp-admin/profile.php">profile</a> and update your email address so that viewers can contact you, and so that we can notify you of new updates and features</p>
	</div>';
}
global $user_email;
get_currentuserinfo();
if(!$user_email){
	add_action('admin_notices', 'admin_notice_email');
}

/*/ Show a notice if user has no email
function admin_notice_help(){
	echo '<div class="error">
	   <p>Please check out the <a href="/wp-admin/admin.php?page=wp-help-documents">help documents</a> to learn how to manage your channel</p>
	</div>';
}
add_action('admin_notices', 'admin_notice_help');*/

/* ------------------------------------------------------------------
|
|
|	Dashboard
|
|
| -------------------------------------------------------------------*/

// Create the function to use in the action hook
function remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'tribe_dashboard_widget', 'dashboard', 'normal' );
} 
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

// Create the helpful links widget
function helpful_dashboard_widget() { 
	?>
		<h4 style="margin-bottom:10px;"><a href="/wp-admin/admin.php?page=wp-help-documents">Help Tutorials</a></h4>
		<div style="float:left;width:49%;">
		<h4>Downloads:</h4>
		<ul>
			<li><a target="_blank" href="http://www.mirovideoconverter.com/download_win.html">Convert Archives to MP4 format (free)</a></li>
			<li><a target="_blank" href="http://www.xsplit.com/">XSplit Broadcaster (paid broadcasting)</a></li>
			<li><a target="_blank" href="http://www.adobe.com/products/flashmediaserver/flashmediaencoder/">Flash Media Live Encoder (free broadcasting)</a></li>
			<li><a target="_blank" href="http://www.mirovideoconverter.com/download_win.html">Convert Archives to MP4 format (free)</a></li>
			<li><a target="_blank" href="http://cdn.pinnaclesys.com/SupportFiles/Hardware_Installer/PCLEUSB2x32.exe">Dazzle Driver (free)</a></li>
		</ul>
		</div>
		<div style="float:left;width:49%;">
		<h4>Equipment List:</h4>
		<ul>
			<li>
				<a target="_blank" 
				href="http://www.ionaudio.com/products/details/video-2-pc">
					Ion Video 2 PC
				</a>
			</li>
			<li>
				<a target="_blank" 
				href="http://www.bestbuy.com/site/Toshiba+-+Satellite+Laptop+/+AMD+E-Series+Processor+/+15.6%26%2334%3B+Display+-+Black/2970255.p?id=1218367938038&skuId=2970255">
					Windows Laptop
				</a>
			</li>
			<li>
				<a target="_blank" 
				href="http://www.bestbuy.com/site/Apple%26%23174%3B+-+MacBook%26%23174%3B+Pro+/+Intel%26%23174%3B+Core%26%23153%3B+i5+Processor+/+13.3%22+Display+/+4GB+Memory+/+320GB+Hard+Drive/9755322.p?id=1218169737492&amp;skuId=9755322">
					Macintosh Laptop
				</a>
			</li>
			<li>
				<a target="_blank" 
				href="http://www.amazon.com/Behringer-802-Premium-8-Input-Preamps/dp/B000J5XS3C/ref=sr_1_1?s=musical-instruments&amp;ie=UTF8&amp;qid=1314940317&amp;sr=1-1">
					2 Channel Audio Mixer
				</a>
			</li>
			<li>				
				<a target="_blank" 
				href="http://www.amazon.com/Behringer-1202-12-Input-Mixer/dp/B000J5Y282/ref=sr_1_6?s=musical-instruments&amp;ie=UTF8&amp;qid=1314940346&amp;sr=1-6">
					4 Channel Audio Mixer
				</a>
			</li>
		</ul>
		</div>
		<div style="clear:both;height:1px;width:100%;"></div>
	<?php 
} 
function add_helpful_dashboard_widget() {
	wp_add_dashboard_widget('helpful_dashboard_widget', 'Links', 'helpful_dashboard_widget');	
	// Global the $wp_meta_boxes variable (this will allow us to alter the array)
	global $wp_meta_boxes;
	// Then we make a backup of your widget
	$my_widget = $wp_meta_boxes['dashboard']['normal']['core']['helpful_dashboard_widget'];
	// We then unset that part of the array
	unset($wp_meta_boxes['dashboard']['normal']['core']['helpful_dashboard_widget']);
	// Now we just add your widget back in
	$wp_meta_boxes['dashboard']['side']['core']['helpful_dashboard_widget'] = $my_widget;
} 
add_action('wp_dashboard_setup', 'add_helpful_dashboard_widget' );

/* ------------------------------------------------------------------
|
|
|	Uploads
|
|
| -------------------------------------------------------------------

// change upload location
function custom_upload_directory( $args ) { 
	if(!empty($args['error'])) { return $args; }
	
  if(of_get_option('media_dir')) {
    $the_dir = of_get_option('media_dir');
  } else {
    $the_dir = 'D:\www\citylinktv\uploads\channel_video';
  }
	
	$args['path'] = $the_dir;
	$args['basedir'] = $the_dir;
		
    return $args;
}
add_filter( 'upload_dir', 'custom_upload_directory' );
*/

// delete attached media files when a post gets deleted
function cltv_delete_post_attachments($post_id) {
    global $wpdb;
 
    $sql = "SELECT ID FROM {$wpdb->posts} ";
    $sql .= " WHERE post_parent = $post_id ";
    $sql .= " AND post_type = 'attachment'";
 
    $ids = $wpdb->get_col($sql);
 
    foreach ( $ids as $id ) {
        echo $id.'<br><br>';
        wp_delete_attachment($id, true);
    }
}
add_action('before_delete_post', 'cltv_delete_post_attachments');
?>