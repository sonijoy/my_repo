<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that also follow
 * WordPress coding standards and PHP best practices.
 *
 * @package   Move_To_Cloudfiles
 * @author    Josh Fester <joshfester@gmail.com>
 * @license   GPL-2.0+
 * @link      https://github.com/joshfester/wp-move-to-cloudfiles
 * @copyright 2013 City Link TV
 *
 * @wordpress-plugin
 * Plugin Name: Move to Cloudfiles
 * Plugin URI:  https://github.com/joshfester/wp-move-to-cloudfiles
 * Description: Moves media to Rackspace Cloudfiles after upload
 * Version:     1.0.0
 * Author:      Josh Fester
 * Author URI:  http://www.joshfester.com
 * Text Domain: move-to-cloudfiles
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( plugin_dir_path( __FILE__ ) . 'class-move-to-cloudfiles.php' );

register_activation_hook( __FILE__, array( 'Move_To_Cloudfiles', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Move_To_Cloudfiles', 'deactivate' ) );

Move_To_Cloudfiles::get_instance();

//Move everything to cloudfiles
function move_to_cloud() {
	// Connect to the cloud
	define('RAXSDK_SSL_VERIFYPEER', false);
	require_once(dirname( __FILE__ ).'/lib/rackspace-cloud/php-opencloud.php');
	$conn = new \OpenCloud\Rackspace(
	    'https://identity.api.rackspacecloud.com/v2.0/',
	    array(
	        'username' => 'Joshua0006',
	        'apiKey' => '7e1b9f1faeffcdf23b205d85d1d8162e'
    ));
	$ostore = $conn->ObjectStore('cloudFiles', 'ORD');
		
	$archives = new WP_Query(array( 
		'post_type'=>'attachment',
		'post_status'=>'inherit',
		'posts_per_page'=>200, 
		//'post_parent__not_in'=>$parents,
		'offset'=>2200,
		'order'=>'ASC',
		'orderby'=>'date'/*,
		'meta_query'=>array(
			array(
				'key'=>'mtc_url_full',
				'value'=>null,
				'compare'=>'NOT EXISTS'
			)
		)*/
	));
	//var_dump($archives);
	//die();
	foreach($archives->posts as $attachment){
		//skip default logos
		if($attachment->post_title == 'default_channel_logo') continue;
		$attachment_ID = $attachment->ID;
		
		//skip unattached media
		$parent = $attachment->post_parent;	
		$parent_type = get_post_type($parent); 
		if($parent_type != 'archive' && $parent_type != 'commercial') continue;
		if($parent == 0) {
			echo ' <br />Unattached <br />';	
			continue;
		}
		
		//get info for container
		$path = 'C:\www\citylinktv\uploads';		
		echo $parent_type.'<br />'; 
		$container_date = '201308';
		$misc = true;
		$expired = false;			
		if ('201309' == date('Ym', strtotime($attachment->post_date_gmt))) {
			$container_date = '201309';
		} 
		
		//figure out post type
		switch($parent_type){
			case 'archive':
				if(date('Y-m-d', strtotime($attachment->post_date)) < date('Y-m-d', strtotime('2013-08-19'))) {
					$expired = true;
					update_post_meta($attachment_ID, 'mtc_status', 'unavailable');		
					echo ' <br />expired - '.$attachment->post_date.' - '.$attachment->post_title.'<br />';
					break;
				}
				$path = 'D:\www\citylinktv\uploads\channel_video\\';
				$misc = false;
				break;
			case 'sponsor':
				$path .= '\sponsor_logo\\';
				$misc = false;
				break;
			case 'channel':
				$path .= '\channel_logo\\';
				$misc = false;
				break;
			case 'commercial':
				if(date('Y-m-d', strtotime($attachment->post_date)) < date('Y-m-d', strtotime('2013-08-26'))) {
					$expired = true;
					update_post_meta($attachment_ID, 'mtc_status', 'unavailable');		
					echo ' <br />expired - '.$attachment->post_title.'<br />';
					break;
				}
				$path = 'D:\www\citylinktv\uploads\channel_video\\';
				$misc = false;
				break;
		}
		
		//skip old videos/misc
		if($expired || $misc) continue;
		
		//debug info
		echo ' <br /><br />type:'.$parent_type.' - date:'.$container_date;
		
		//give it a container
		update_post_meta($attachment_ID, 'cloudfiles_container', $parent_type.'s-'.$container_date);
		
		//get the container
		$meta_cont = get_post_meta( $attachment_ID, 'cloudfiles_container', true );
		
		//make an array of files
		$attachments = array('full' => get_attached_file($attachment_ID, true));	
		if(wp_attachment_is_image($attachment_ID)) {
			$sizes = get_intermediate_image_sizes();
			foreach($sizes as $size) {			
				$image = wp_get_attachment_image_src($attachment_ID, $size);	
				if(file_exists($path.basename($image[0]))){
					$attachments[$size] = $path.basename($image[0]);
				}
			}
		}
		
		//get the container
		echo ' container:'.$meta_cont.'<br />';	
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
	
		// Loop through each file
		foreach($attachments as $size => $attachment){	
			// Upload the file
			$name = basename($attachment);	
			if(!file_exists($path.$name)) continue;				
			try {
				$obj = $cont->DataObject($name);
				if(!empty($obj)){					
					update_post_meta($attachment_ID, 'mtc_url_'.$size, $obj->PublicURL());
					echo $obj->PublicURL().'<br />';
					if(!wp_attachment_is_image($attachment_ID)) {
						update_post_meta($attachment_ID, 'mtc_streaming', $obj->PublicURL('streaming'));
						update_post_meta($attachment_ID, 'mtc_ios', $obj->Container()->CDNinfo('Ios-Uri').'/'.$name);
						echo $obj->PublicURL('streaming').'<br />';
						echo $obj->Container()->CDNinfo('Ios-Uri').'/'.$name.'<br />';
					}	
					update_post_meta($attachment_ID, 'mtc_status', 'complete');			
				} 
			} catch(Exception $e){
				update_post_meta($attachment_ID, 'mtc_status', 'error -'.$e);	
				echo 'error - '.$name.' - '.$e.'<br /><br /><br /><br />';
			}
		}
	}	
}
