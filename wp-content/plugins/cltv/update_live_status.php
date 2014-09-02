<?php
/* plugin creates a new endpoint and updates the live status of the channels based off of connectioncount from wowza */
add_action("init", "cltv_init_live_status");

function cltv_init_live_status(){
	// http://www.citylinktv.com/cltv_update_live_status
	add_rewrite_endpoint( "cltv_update_live_status", EP_PERMALINK );
}

add_action("template_redirect", "cltv_do_update_live_status");

function cltv_do_update_live_status(){
	header( "HTTP/1.1 200 OK" );
	header("Cache-Control: no-cache, must-revalidate");

	if ( ! get_query_var( 'cltv_update_live_status' ) )
	{
		return;
	}

	$url = "http://stream.citylinktv.com:8086/connectioncounts";
	$username = "brandon";
	$password = "Bohannon99";

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
	curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	$return = curl_exec($curl);
	curl_close($curl);

	$xml = simplexml_load_string($return);

	$applications = $xml->VHost->Application;
	if ( is_array($applications) ){
		foreach ( $applications as $app ){
			if ( (string)$app->Name == "livepkgr" ){
				$application = $app;
				break;
			}
		}
	} else {
		$application = $applications;
	}

	$streams = $application->ApplicationInstance->Stream;
	$live_streams = array();
	// if there is more than one thing streaming
	foreach ( $streams as $stream ){
		$live_streams[] = (string)$stream->Name;
	}

	echo "First pass<br />";
	$updated = array();
	// update the status of the currently live channels
	$currently_live = cltv_get_live_channels();
	foreach ( $currently_live as $channel ){
		$stream_key = get_post_meta($channel->ID, "stream_key");
		echo $stream_key[0] . " ";
		$updated[] = $stream_key[0];
		if ( in_array($stream_key[0],$live_streams) ){
			echo "Set live<br />";
			update_post_meta($channel->ID,"is_live",true);
		} else {
			echo "Unset live<br />";
			update_post_meta($channel->ID,"is_live",false);
		}
	}
	echo "<br />";
	echo "Second Pass<br />";
	// now process the channels that need to be made live
	// I couldn't figure out a way to do this in one pass...
	$diff = array_diff($live_streams,$updated);
	foreach ( $diff as $stream ){
		echo $stream;
		$args = array("post_type"=>"channel",
				"meta_key" => "stream_key",
				"meta_value" => $stream,
				"posts_per_page"=>1,
				"orderby"=>"title",
				"order"=>"ASC"
		);
		$new_live = get_posts($args);
		if ( count($new_live) > 0 ){
			echo "Channel found by stream key - set live";
			update_post_meta($new_live[0]->ID, "is_live", true);
		} else {
			echo " Channel not found by stream key";
		}
		echo "<br />";
	}
	exit;
}

add_filter("request", "cltv_update_live_status_request" );

function cltv_update_live_status_request ( $vars ) {
	( $vars['name'] == "cltv_update_live_status" ) and $vars['cltv_update_live_status'] = true;
	return $vars;
}

function cltv_set_channel_live($stream_name){

}
