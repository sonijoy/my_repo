<?php

/* ------------------------------------------------------------------
|
|
|	JS and CSS files
|
| -------------------------------------------------------------------*/

function theme_styles()
{
  wp_register_style( 'bootstrap', '//netdna.bootstrapcdn.com/bootswatch/2.3.2/cosmo/bootstrap.min.css', array(), '1.0', 'all' );
  wp_register_style( 'bootstrap-responsive', '//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-responsive.min.css', array(), '1.0', 'all' );
  wp_register_style( 'fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', array(), '1.0', 'all' );
  wp_register_style( 'wp-bootstrap', get_template_directory_uri() . '/style.css', array(), '1.0', 'all' );
	wp_register_style( 'mCustomScrollbar', get_template_directory_uri() . '/library/css/jquery.mCustomScrollbar.css', array(), '1.0', 'all' );
	wp_register_style( 'custom', get_template_directory_uri() . '/library/css/custom.css', array(), '1.03', 'all' );

  wp_enqueue_style( 'bootstrap' );
  wp_enqueue_style( 'bootstrap-responsive' );
  wp_enqueue_style( 'fontawesome' );
  wp_enqueue_style( 'wp-bootstrap');
	wp_enqueue_style( 'mCustomScrollbar' );
	wp_enqueue_style( 'custom' );
}
add_action('wp_enqueue_scripts', 'theme_styles');

// enqueue javascript

function theme_js(){
  wp_deregister_script('jquery'); // initiate the function
	wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js', null, '1.8.3', false);
	wp_register_script('bootstrap', '//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js', array('jquery'), '2.3.2', true);
	wp_register_script('modernizr', get_template_directory_uri().'/library/js/modernizr.full.min.js', array('jquery'), '2.6.2', true);
	wp_register_script('jquery-mousewheel', get_template_directory_uri().'/library/js/jquery.mousewheel.min.js', array('jquery'), '1.0', true);
	wp_register_script('mCustomScrollbar', get_template_directory_uri().'/library/js/jquery.mCustomScrollbar.min.js', array('jquery'), '1.0', true);
	wp_register_script('jwplayer', 'http://jwpsrv.com/library/NjlOvgLxEeO21iIACusDuQ.js', null, null, false);
  wp_register_script('main', get_template_directory_uri().'/library/js/main.js', array('jquery','bootstrap','modernizr','jquery-mousewheel','mCustomScrollbar', 'jwplayer'), '1.03', true);

	wp_enqueue_script('jquery');
	wp_enqueue_script('bootstrap');
	wp_enqueue_script('modernizr');
	wp_enqueue_script('jquery-mousewheel');
	wp_enqueue_script('mCustomScrollbar');
  wp_enqueue_script('jwplayer');
	wp_enqueue_script('main');
}
add_action('wp_enqueue_scripts', 'theme_js');

function my_admin_head() {
	if(current_user_can('channel')){
		wp_enqueue_style( 'admin_channel_css', get_template_directory_uri() . '/library/css/admin.channel.css' );
	}

	wp_register_script('admin_js', get_template_directory_uri().'/library/js/admin.js');
	wp_enqueue_script('admin_js', array('jQuery'), '1.11', true);
}
add_action('admin_enqueue_scripts', 'my_admin_head');
