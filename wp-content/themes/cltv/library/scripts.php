<?php

/* ------------------------------------------------------------------
|
|
|	JS and CSS files
|<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
|
| -------------------------------------------------------------------*/

function theme_styles()  
{ 
    // This is the compiled css file from LESS - this means you compile the LESS file locally and put it in the appropriate directory if you want to make any changes to the master bootstrap.css.
   // Bootstrap is hardcoded into the header to play nice with the Autoptimizer plugin
   //wp_register_style( 'bootstrap', '//netdna.bootstrapcdn.com/bootswatch/2.3.2/cosmo/bootstrap.min.css', array(), '1.0', 'all' );
   // wp_register_style( 'bootstrap-responsive', '//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-responsive.min.css', array('bootstrap'), '1.0', 'all' );
    wp_register_style( 'wp-bootstrap', get_template_directory_uri() . '/style.css', array(), '1.0', 'all' );
	wp_register_style( 'mCustomScrollbar', get_template_directory_uri() . '/library/css/jquery.mCustomScrollbar.css', array(), '1.0', 'all' );
	wp_register_style( 'custom', get_template_directory_uri() . '/library/css/custom.css', array(), '1.03', 'all' );
    
    wp_enqueue_style( 'bootstrap' );
    wp_enqueue_style( 'bootstrap-responsive' );
    wp_enqueue_style( 'wp-bootstrap');
	wp_enqueue_style( 'mCustomScrollbar' );
	wp_enqueue_style( 'custom' );
}
add_action('wp_enqueue_scripts', 'theme_styles');

// enqueue javascript

function theme_js(){
  // wp_register_script('less', get_template_directory_uri().'/library/js/less-1.3.0.min.js');

	wp_deregister_script('jquery'); // initiate the function  
	wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js', false, '1.8.3');
	//wp_register_script('jquery-migrate', 'http://code.jquery.com/jquery-migrate-1.2.1.min.js', false, '1.1.1');
	wp_register_script('bootstrap', '//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js', array('jquery'), '2.3.2', true);
	//wp_register_script('wpbs-scripts', get_template_directory_uri().'/library/js/scripts.js');
	wp_register_script('modernizr', get_template_directory_uri().'/library/js/modernizr.full.min.js', array('jquery'), '2.6.2', true);
	wp_register_script('jquery-mousewheel', get_template_directory_uri().'/library/js/jquery.mousewheel.min.js', array('jquery'), '1.0', true);
	wp_register_script('mCustomScrollbar', get_template_directory_uri().'/library/js/jquery.mCustomScrollbar.min.js', array('jquery'), '1.0', true);
	wp_register_script('custom', get_template_directory_uri().'/library/js/custom.js', array('jquery','bootstrap','modernizr','jquery-mousewheel','mCustomScrollbar'), '1.03', true);

	// wp_enqueue_script('less', array(''), '1.3.0', true);
	wp_enqueue_script('jquery');
	//wp_enqueue_script('jquery-migrate');
	wp_enqueue_script('bootstrap');
	//wp_enqueue_script('wpbs-scripts', array('jQuery'), '1.1', true);
	wp_enqueue_script('modernizr');
	wp_enqueue_script('jquery-mousewheel');
	wp_enqueue_script('mCustomScrollbar');
	wp_enqueue_script('custom');
}
add_action('wp_enqueue_scripts', 'theme_js');