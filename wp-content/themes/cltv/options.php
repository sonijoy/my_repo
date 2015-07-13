<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$the_theme = wp_get_theme();
	$themename = $the_theme->Name;
	$themename = preg_replace("/\W/", "", strtolower($themename) );

	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);

	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options() {
	$options = array();

	$options[] = array( "name" => "General",
						"type" => "heading");

	$options[] = array( "name" => "Global Message Board",
					"desc" => "",
					"id" => "global_admin_message",
					"std" => "",
					"type" => "text");

	$options[] = array( "name" => "Streaming",
						"type" => "heading");

	$options[] = array( "name" => "Woza Server",
					"desc" => "",
					"id" => "wowza_server",
					"std" => "http://wowza.citylinktv.com/",
					"type" => "text");

  $options[] = array( "name" => "Woza CDN",
					"desc" => "",
					"id" => "wowza_cdn",
					"std" => "http://streamcdn.citylinktv.com/",
					"type" => "text");

	$options[] = array( "name" => "Use Woza CDN?",
					"desc" => "",
					"id" => "use_wowza_cdn",
					"type" => "checkbox");

	$options[] = array( "name" => "Archive RTMP",
						"desc" => "",
						"id" => "archive_rtmp",
						"std" => "rtmp://rtmpuploads.citylinktv.com/cfx/st/",
						"type" => "text");

	$options[] = array( "name" => "Recorded RTMP",
						"desc" => "",
						"id" => "recorded_rtmp",
						"std" => "rtmp://recordings.citylinktv.com/cfx/st/",
						"type" => "text");

	return $options;
}

?>
