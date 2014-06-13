<?php
/*
Template Name: Insert Archives

SELECT id, channel_id, name, video_file, created_at
FROM video
ORDER BY  `video`.`id` ASC 



$archives = array(
  array('id'=>'7162','channel_id'=>'154','name'=>'Mayoral Address 2013:  Our Road to the Future','video_file'=>'KasparMediaFrankfort-2013-05-30-18-04-34-movie.mp4','description'=>'Mayor McBarnes outlines his vision for Frankfort, Indiana.  This message was also broadcast on WILO 1570 and WILO 94.1 FM','is_permanent'=>'0','expiration_date'=>'2012-12-21 00:00:00','display_date'=>'2013-06-08 00:00:00','created_at'=>'2013-05-30 18:04:34','updated_at'=>'2013-08-14 00:17:19','is_ios_compatible'=>'0'),
  array('id'=>'7231','channel_id'=>'154','name'=>'Vern Kaspar Community Announcement Pt 1','video_file'=>'KasparMediaFrankfort-2013-06-04-17-48-34-Farmers Bank Announcement.10.mp4','description'=>'Vern Kaspar makes Ivy Tech announcement','is_permanent'=>'0','expiration_date'=>'2012-12-21 00:00:00','display_date'=>'2013-06-05 00:00:00','created_at'=>'2013-06-04 17:48:34','updated_at'=>'2013-08-14 00:17:12','is_ios_compatible'=>'0'),
  array('id'=>'7232','channel_id'=>'154','name'=>'Vern Kaspar Community Announcement Pt 2','video_file'=>'KasparMediaFrankfort-2013-06-04-18-21-55-vjk announcement 2.mp4','description'=>'Vern Kaspar Ivy Tech Community announcement Part 2','is_permanent'=>'0','expiration_date'=>'2012-12-21 00:00:00','display_date'=>'2013-06-04 00:00:00','created_at'=>'2013-06-04 18:21:55','updated_at'=>'2013-08-14 00:17:16','is_ios_compatible'=>'0'),
);*/


if(isset($_POST['id']) && isset($_POST['video_file'])){
	$archives = array( 0 => array(
		'id'=>$_POST['id'],
		'channel_id'=>$_POST['channel_id'],
		'name'=>$_POST['archive_name'],
		'video_file'=>$_POST['video_file']
	));	
	
} 

foreach($archives as $archive) {
	//make sure archive has a channel
	if($archive['channel_id']) {
		//make sure archive doesn't already exist
		$insert = true;
		$old_archive = new WP_Query(array('post_type'=>'archive', 'meta_key'=>'legacy_archive', 'meta_value'=>$archive['id']));
		if($old_archive->have_posts()) $insert = false;
		wp_reset_postdata();
		
		//definitely inserting
		if($insert){
			//get the attached channel
			$channel_q = new WP_Query(array('post_type'=>'channel', 'meta_key'=>'legacy_channel', 'meta_value'=>$archive['channel_id']));
			if($channel_q->found_posts == 1) {	
				//set archive args
				$channel = $channel_q->posts[0];
				$args = array(
					'post_author' => $channel->post_author,
					'post_title' => $archive['name'],
					'post_type' => 'archive',
					'post_status' => 'publish'
				);
				
				//insert archive
				$post_id = wp_insert_post($args);			
				add_post_meta($post_id, 'legacy_archive', $archive['id']); 
				add_post_meta($post_id, 'channel', $channel->ID); 
				
				//insert the video
				$filename = $archive['video_file'];			
				if($post_id) {				
					$wp_filetype = wp_check_filetype(basename($filename), null );
					$attachment = array(
						'guid' => 'http://www.citylinktv.com/uploads' . '/' . basename( $filename ), 
						'post_mime_type' => $wp_filetype['type'],
						'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
						'post_content' => '',
						'post_status' => 'inherit'
					);
					$attach_id = wp_insert_attachment( $attachment, $filename, $post_id );
					require_once(ABSPATH . 'wp-admin/includes/image.php');
					$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
					wp_update_attachment_metadata( $attach_id, $attach_data );					
					add_post_meta($post_id, 'video_file', $attach_id); 
				}
			} 
			wp_reset_postdata();
		}
	}
}