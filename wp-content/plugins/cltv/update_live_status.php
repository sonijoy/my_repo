<?php
/* plugin creates a new endpoint and updates the live status of the channels based off of connectioncount from wowza */
add_action("init", "cltv_init_live_status");

function cltv_init_live_status(){
	// http://www.citylinktv.com/cltv_update_live_status
	add_rewrite_endpoint( 'cltv_update_live_status', "cltv_update_live_status" );
}

add_action("template_redirect", "cltv_update_live_status");

function cltv_update_live_status(){
	if ( ! is_singular() or ! get_query_var( 'cltv_update_live_status' ) )
	{
		return;
	}

	echo "It works";
}

add_filter( 'request', 'cltv_update_live_status_request' );

function cltv_update_live_status_request( $vars ) {
	isset( $vars['cltv_update_live_status'] ) and $vars['cltv_update_live_status'] = true;
	return $vars;
}