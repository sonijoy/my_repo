<?php
/**
 * Plugin Name.
 *
 * @package   Move_To_Cloudfiles
 * @author    Josh Fester <joshfester@gmail.com>
 * @license   GPL-2.0+
 * @link      https://github.com/joshfester/wp-move-to-cloudfiles
 * @copyright 2013 City Link TV
 */

/**
 * Plugin class.
 *
 * @package Move_To_Cloudfiles
 * @author  Josh Fester <joshfester@gmail.com>
 */
 

 
class Move_To_Cloudfiles {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @const   string
	 */
	const VERSION = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'move-to-cloudfiles';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		// Create custom event
		//add_action( 'move_to_cloudfiles_event', array($this, 'move_attachment_to_cloudfiles'), 10, 2 );
		// Schedule the event
		//add_action( 'add_attachment', array( $this, 'schedule_mtc_event' ) );	
		// Rewrite attachment paths	
		//add_filter( 'get_attached_file', array($this, 'mtc_get_attached_file'), 10, 2 );
		add_filter( 'post_thumbnail_html', array($this, 'mtc_image_attrs'), 10, 5 );
	} 

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
	
	/**
	 * Takes an attachment ID and schedules a single event to move it to the cloud
	 * after adding postmeta for a Rackspace Cloud Files container
	 *
	 * @since    1.0.0
	 */
	public function schedule_mtc_event($attachment_ID) {
		// Get the post type and container date
		$post_type = get_post_type($attachment_ID);	
		$parent = get_post( $attachment_ID )->post_parent;	
		$parent_type = get_post_type($parent);
		$container = get_post_meta($attachment_ID, 'cloudfiles_container', true);
		$container_date = date('Ym');
		$types = array('archive', 'commercial', 'channel', 'sponsor');
		$misc = true;	
		
		// Get attachment and all files
		$attachment = get_attached_file($attachment_ID, true);				
		
		// Figure out what the post type is 
		foreach($types as $type) {
			if($type == $post_type || $type == $parent_type) {
				// Create meta for container if this is a new file
				update_post_meta($attachment_ID, 'cloudfiles_container', $type.'s-'.$container_date);
				// This is not a misc upload
				$misc = false;
				break;
			}
		}
		// If it's a misc upload
		if($misc){
			update_post_meta($attachment_ID, 'cloudfiles_container', 'misc-'.$container_date);
		}
		
		//Schedule the upload event
		wp_schedule_single_event( time(), 'move_to_cloudfiles_event', array($attachment_ID, $attachment) );
	}

	/**
	 * Takes an attachment ID and moves that attachment to Rackspace Cloud Files
	 *
	 * @since    1.0.0
	 */
	public function move_attachment_to_cloudfiles($attachment_ID, $attachment) {		
		// Loop through all sizes if attachment is an image
		$attachments = array('full' => $attachment);	
		if(wp_attachment_is_image($attachment_ID)) {
			$sizes = get_intermediate_image_sizes();
			foreach($sizes as $size) {
				$path_parts = pathinfo($attachment);
				$image = wp_get_attachment_image_src($attachment_ID, $size);
				$attachments[$size] = $path_parts['dirname'].'/'.basename($image[0]);
			}
		}
		
		// Connect to the cloud
		try {
			define('RAXSDK_SSL_VERIFYPEER', false);
			require_once(dirname( __FILE__ ).'/lib/rackspace-cloud/php-opencloud.php');
			$conn = new \OpenCloud\Rackspace(
			    'https://identity.api.rackspacecloud.com/v2.0/',
			    array(
			        'username' => 'Joshua0006',
			        'apiKey' => '7e1b9f1faeffcdf23b205d85d1d8162e'
		    ));
			$ostore = $conn->ObjectStore('cloudFiles', 'ORD');
		} 
		// Mark the attachment if failed connecting
		catch(Exception $e) {
			add_post_meta($attachment_ID, 'mtc_error', 'connect--'.$e->getMessage(), true);
			return;
		}
		
		// Get or create container
		try {
			$meta_cont = get_post_meta( $attachment_ID, 'cloudfiles_container', true );			
			$cont = false;
			$contlist = $ostore->ContainerList();
			while($container = $contlist->Next()) {
			    if($container->name == $meta_cont){
			    	$cont = $ostore->Container($meta_cont);
			    }
			}
			if(!$cont){
				$cont = $ostore->Container();
				$cont->Create(array('name'=>$meta_cont));
				$cont->PublishToCDN();
			}
		} 
		// Mark the attachment if failed container
		catch(Exception $e) {
			add_post_meta($attachment_ID, 'mtc_error', 'container--'.$e->getMessage(), true);
			return;
		}

		// Loop through each file
		foreach($attachments as $size => $attachment){	
			// Upload the file
			try {			
				$obj = $cont->DataObject();
				$name = basename($attachment);
				update_post_meta($attachment_ID, 'mtc_status', 'started');
				$obj->Create(array('name' => $name, 'content_type' => get_post_mime_type($attachment_ID)), $attachment);
				update_post_meta($attachment_ID, 'mtc_url_'.$size, $obj->PublicURL());
				update_post_meta($attachment_ID, 'mtc_streaming', $obj->PublicURL('streaming'));
				update_post_meta($attachment_ID, 'mtc_ios', $obj->Container()->CDNinfo('Ios-Uri').'/'.$name);
				update_post_meta($attachment_ID, 'mtc_status', 'complete');
			} 
			// Mark the attachment if failed uploading
			catch(Exception $e) {
				update_post_meta($attachment_ID, 'mtc_status', 'error - '.$e->getMessage());
				return;
			}
		}
	}	

	/**
	 * Changes the attachment path to match cloud location
	 *
	 * @since    1.0.0
	 */
	public function mtc_get_attached_file($file, $attachment_id){
		if(get_post_meta($attachment_id, 'mtc_status', true) == 'complete'){
			$cdn_url = get_post_meta($attachment_id, 'mtc_url_full', true);
			if(!empty($cdn_url)) {			
				$file = $cdn_url;
			} 
		}
		
		return $file;
	}
	
	/**
	 * Changes the attachment path to match cloud location
	 *
	 * @since    1.0.0
	 */
	public function mtc_image_attrs($html, $post_id, $post_thumbnail_id, $size, $attr){
		if(get_post_meta($post_thumbnail_id, 'mtc_status', true) == 'complete'){
			$cdn_url = get_post_meta($post_thumbnail_id, 'mtc_url_'.$size, true); 
			if(!empty($cdn_url)) {			
				$attr['src'] = $cdn_url; 
				$html = '<img ';
				foreach($attr as $at => $val) {
					$html .= ' '.$at.'="'.$val.'" ';
				}
				$html .= ' />';
			} 		
		}
		return $html;
	}
	

}
