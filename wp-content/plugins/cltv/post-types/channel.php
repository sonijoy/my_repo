<?php

// Channel post type
function custom_post_channel() {
	register_post_type( 'channel', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		array('labels' => array(
			'name' => __('Channels'), /* This is the Title of the Group */
			'singular_name' => __('Channel'), /* This is the individual type */
			'all_items' => __('All Channels'), /* the all items menu item */
			'add_new' => __('Add New'), /* The add new menu item */
			'add_new_item' => __('Add New Channel'), /* Add New Display Title */
			'edit' => __( 'Edit' ), /* Edit Dialog */
			'edit_item' => __('Edit Channel'), /* Edit Display Title */
			'new_item' => __('New Channel'), /* New Display Title */
			'view_item' => __('View Channel'), /* View Display Title */
			'search_items' => __('Search Channel'), /* Search Custom Type Title */
			'not_found' =>  __('Nothing found in the Database.'), /* This displays if there are no entries yet */
			'not_found_in_trash' => __('Nothing found in Trash'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( '' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
			'menu_icon' => 'dashicons-video-alt', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'channel', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'channel', /* you can rename the slug here */
			'capability_type' => 'channel',
			'hierarchical' => false,
			'supports' => array( 'title', 'thumbnail', 'author'),
			'map_meta_cap' => true
	 	) /* end of options */
	); /* end of register post type */

	// channel categories taxonomy
    register_taxonomy( 'channel_cat',
    	array('channel'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    	array('hierarchical' => true,     /* if this is true, it acts like categories */
    		'labels' => array(
    			'name' => __( 'Channel Categories' ), /* name of the custom taxonomy */
    			'singular_name' => __( 'Channel Category' ), /* single taxonomy name */
    			'search_items' =>  __( 'Search Channel Categories' ), /* search title for taxomony */
    			'all_items' => __( 'All Channel Categories' ), /* all title for taxonomies */
    			'parent_item' => __( 'Parent Channel Category' ), /* parent title for taxonomy */
    			'parent_item_colon' => __( 'Parent Channel Category:' ), /* parent taxonomy title */
    			'edit_item' => __( 'Edit Channel Category' ), /* edit custom taxonomy title */
    			'update_item' => __( 'Update Channel Category' ), /* update title for taxonomy */
    			'add_new_item' => __( 'Add New Channel Category' ), /* add new title for taxonomy */
    			'new_item_name' => __( 'New Channel Category Name' ) /* name title for taxonomy */
    		),
    		'show_ui' => true,
    		'query_var' => true,
    		'rewrite' => array( 'slug' => 'channel-cat' ),
			'capabilities' => array(
				'manage_terms' => 'manage_channel_cats',
				'edit_terms' => 'manage_channel_cats',
				'delete_terms' => 'manage_channel_cats',
				'assign_terms' => 'assign_channel_cats'
			)
    	)
    );
}
add_action( 'init', 'custom_post_channel');

?>
