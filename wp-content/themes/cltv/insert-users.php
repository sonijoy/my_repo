<?php
/*
Template Name: Insert Users

SELECT id, username
FROM sf_guard_user
ORDER BY  `sf_guard_user`.`id` ASC


$users = array(
  array('id'=>'290','username'=>'louisburg'),
  array('id'=>'291','username'=>'enid')
);

*/
define('WP_DEBUG', true);
error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(720);
move_to_cloud();
echo 'yay';

/*


foreach($users as $user) {

	if($user['username']) {
		
		$legacy  = get_users(array('meta_key'=>'legacy_user', 'meta_value'=>$user['id']));
		$username = username_exists($user['username']);
		if(!$legacy && !$username){
			$id = wp_create_user($user['username'], $user['username']);
			add_user_meta( $id, 'legacy_user', $user['id'] );
		}
		
	}
}*/