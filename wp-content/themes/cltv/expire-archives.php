<?php
/*
Template Name: Expire Archives
*/

file_put_contents('C:\www\citylinktv\uploads\test.txt', PHP_EOL .'Expiring videos ' . date('Y-m-d') . PHP_EOL, FILE_APPEND);
global $wpdb;
$post_type = 'archive';

# Query post type
$query = "
	SELECT ID FROM $wpdb->posts 
	WHERE post_type = '$post_type' 
	AND post_date < DATE_SUB(NOW(), INTERVAL 1 MONTH) 
	ORDER BY post_modified DESC
";
$results = $wpdb->get_results($query);
file_put_contents('C:\www\citylinktv\uploads\test.txt', '...results:' . count($results) . PHP_EOL, FILE_APPEND);

# Check if there are any results
if(count($results)){
	foreach($results as $post){
		# Let the WordPress API do the heavy lifting for cleaning up entire post trails
		file_put_contents('C:\www\citylinktv\uploads\test.txt', '...post_id-' . $post->ID . PHP_EOL, FILE_APPEND);
		$purge = wp_delete_post($post->ID);
	}
}