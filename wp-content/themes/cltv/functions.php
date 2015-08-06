<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// Get Bones Core Up & Running!
require_once(TEMPLATEPATH.'/library/scripts.php');

// Options panel
require_once('library/options-panel.php');

add_theme_support( 'post-thumbnails' );

// Set content width
if ( ! isset( $content_width ) ) $content_width = 580;

// Remove height/width attributes on images so they can be responsive
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

// Add thumbnail class to thumbnail links
function add_class_attachment_link($html){
    $postid = get_the_ID();
    $html = str_replace('<a','<a class="thumbnail"',$html);
    return $html;
}
add_filter('wp_get_attachment_link','add_class_attachment_link',10,1);

// remove "protected: " from titles
function protect_my_privates($text){
  $text='%s';
  return $text;
}
add_filter('private_title_format','protect_my_privates');
add_filter('protected_title_format', 'protect_my_privates');

// Show a notice if user has no email
function admin_notice_message(){
  $message = of_get_option('global_admin_message');
  if(!$message){
  	return;
  }
  $html = '<div style="width:100%;clear:both;"></div>';
  $html .= '<div class="update-nag message-nag" style="border:1px solid #7ad03a;font-size:15px;display:block;">';
  $html .= of_get_option('global_admin_message');
	$html .= '</div>';

  echo $html;
}
add_action('admin_notices', 'admin_notice_message');

?>
