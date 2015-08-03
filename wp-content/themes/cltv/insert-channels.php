<?php
/*
Template Name: Insert Channels

SELECT channel.id, channel.name, channel.logo_file, channel.state, channel_category.name AS  'category', channel.stream_key, sf_guard_user.username
FROM channel
LEFT JOIN sf_guard_user ON sf_guard_user.id = channel.user_id
LEFT JOIN channel_category ON channel_category.id = channel.channel_category_id

$channels = array(
  array('id'=>'280','name'=>'Louisburg','logo_file'=>'e4dfc6779fcaa3f408bc388f038c3ec5fcb5d438.jpg','state'=>'KS','category'=>'Cities','stream_key'=>'louisburg','username'=>'louisburg'),
  array('id'=>'281','name'=>'Enid Buzz','logo_file'=>'default_channel_logo.jpg','state'=>'OK','category'=>'Cities','stream_key'=>'enid','username'=>'enid')
);
*/

if(isset($_POST['id']) && isset($_POST['stream_key'])){
	$channels = array( 0 => array(
		'id'=>$_POST['id'],
		'stream_key'=>$_POST['stream_key'],
		'is_live'=>$_POST['is_live']
	));	
}

foreach($channels as $channel) {
	//if channel has a username
	if($channel['id']) {
	
		//set channel args
		$insert = true;
		
		//check if we will update instead of insert
		$exists  = new WP_Query(array('post_type'=>'channel', 'meta_key'=>'legacy_channel', 'meta_value'=>$channel['id']));
		if ($exists->found_posts == 1){
			update_post_meta($exists->posts[0]->ID, 'stream_key', $channel['stream_key']);
			update_post_meta($exists->posts[0]->ID, 'is_live', $channel['is_live']);
			file_put_contents('C:\www\citylinktv\uploads\test.txt', ' Post ID:'.$exists->posts[0]->ID, FILE_APPEND);
			$insert = false;
		} elseif ($exists->found_posts > 1) die('Channels are jacked up ');
		wp_reset_postdata();
		
		if($insert && $channel['username']){
			//check for user
			$user = get_user_by('login', $channel['username']);
			$args = array(
				'post_author' => $user->ID,
				'post_title' => $channel['name'],
				'post_type' => 'channel',
				'post_status' => 'publish'
			);
			$post_id = wp_insert_post($args);
		}			
		
		//if update/insert was successful and channel didn't already exist
		if($insert && $post_id) {
			//add channel meta
			add_post_meta($post_id, 'state', $channel['state']); 
			add_post_meta($post_id, 'legacy_channel', $channel['id']);
			add_post_meta($post_id, 'stream_key', $channel['stream_key']);
			
			//add channel_cat taxonomy
			$cat = '';
			if($channel['category'] == 'Cities') {
				$cat = array(2);
			} else if($channel['category'] == 'Churches') {
				$cat = array(4);
			} else if($channel['category'] == 'Sports') {
				$cat = array(3);
			} else if($channel['category'] == 'Schools') {
				$cat = array(5);
			}
			wp_set_post_terms($post_id, $cat, 'channel_cat'); 
			
			//insert the thumbnail
			$filename = $channel['logo_file'];
			$wp_filetype = wp_check_filetype(basename($filename), null );
			$attachment = array(
				'guid' => 'http://www.citylinktv.com/channel-logo' . '/' . basename( $filename ), 
				'post_mime_type' => $wp_filetype['type'],
				'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
				'post_content' => '',
				'post_status' => 'inherit'
			);
			$attach_id = wp_insert_attachment( $attachment, $filename, $post_id );
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
			wp_update_attachment_metadata( $attach_id, $attach_data );				
			update_post_meta( $post_id,'_thumbnail_id',$attach_id);
		}	
	}
}