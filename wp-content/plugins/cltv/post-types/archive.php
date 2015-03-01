<?php

add_action( 'init', 'custom_post_archive_init');

// Archive post type and all things associated with it
function custom_post_archive_init() {

	register_post_type( 'archive', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		array('labels' => array(
			'name' => __('Archives'), /* This is the Title of the Group */
			'singular_name' => __('Archive'), /* This is the individual type */
			'all_items' => __('All Archives'), /* the all items menu item */
			'add_new' => __('Add New'), /* The add new menu item */
			'add_new_item' => __('Add New Archive'), /* Add New Display Title */
			'edit' => __( 'Edit' ), /* Edit Dialog */
			'edit_item' => __('Edit Archive'), /* Edit Display Title */
			'new_item' => __('New Archive'), /* New Display Title */
			'view_item' => __('View Archive'), /* View Display Title */
			'search_items' => __('Search Archive'), /* Search Custom Type Title */
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
			'menu_icon' => 'dashicons-media-video', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'archive', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'archive', /* you can rename the slug here */
			'capability_type' => 'archive',
			'hierarchical' => false,
			'supports' => array( 'title', 'author', 'thumbnail'),
			'map_meta_cap' => true
	 	) /* end of options */
	); /* end of register post type */
}

?>
