<?php

/* ------------------------------------------------------------------
|
|
|	Utility functions
|
|
| -------------------------------------------------------------------*/


// Trim strings and add "..."
function cltv_trim($str, $len = 19) {
	$s = substr($str, 0, $len); 
	if(strlen($str) > $len) 
		$s .= '&hellip;';
	$s = ucwords(strtolower($s));
	return $s;
}

// Get all US states
function cltv_states() {
	return array('AL' => 'Alabama', 'AK' => 'Alaska', 'AR' => 'Arkansas',
        'AZ' => 'Arizona', 'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DC' =>
        'District of Columbia', 'DE' => 'Delaware', 'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii',
        'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas', 'KY' =>
        'Kentucky', 'LA' => 'Louisiana', 'MA' => 'Massachusetts', 'MD' => 'Maryland', 'ME' => 'Maine', 'MI' =>
        'Michigan', 'MN' => 'Minnesota', 'MO' => 'Missouri', 'MS' => 'Mississippi', 'MT' => 'Montana', 'NC' =>
        'North Carolina', 'ND' => 'North Dakota', 'NE' => 'Nebraska', 'NH' => 'New Hampshire', 'NJ' =>
        'New Jersey', 'NM' => 'New Mexico', 'NV' => 'Nevada', 'NY' => 'New York', 'OH' => 'Ohio', 'OK' =>
        'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' =>
        'South Carolina', 'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VA' =>
        'Virginia', 'VT' => 'Vermont', 'WA' => 'Washington', 'WI' => 'Wisconsin', 'WV' => 'West Virginia',
        'WY' => 'Wyoming');
}

// generate the src paramter for video player
function cltv_format_video_src($video, $live=false, $http=false, $attachment_id=0) {	
	//live videos
	if($live){
      $src['html5'] = of_get_option('live_http').'livepkgr/'.$video.'/playlist.m3u8';
      $src['flash'] = false;
	} 
	//archive video
	else {
      $recorded = get_post_meta($attachment_id, 'recorded', true);
      $path_parts = pathinfo($video);
      $filename = $path_parts['basename'];
      if($recorded) {
        $src['html5'] = of_get_option('wowza_cdn').'_definst_/vods3/mp4:amazons3/cltv-recordings/'.$filename.'/playlist.m3u8';
        $src['flash'] = of_get_option('recorded_rtmp').$filename;
      } else {
        $src['html5'] = of_get_option('wowza_cdn').'_definst_/vods3/mp4:amazons3/cltv-archives/'.$filename.'/playlist.m3u8';
        $src['flash'] = of_get_option('archive_rtmp').$filename;
      }
	}	 
	
	return $src;
}

// generate filename/streamkey and poster
function cltv_channel_video($id){
	//default poster is the post's featured image
	$poster = wp_get_attachment_image_src(get_post_thumbnail_ID($id), 'full');
	$poster = $poster[0];
	$title = get_the_title($id);
	$filename = false;
	$live = false;		
	$attachment_id = false;
	
	//if showing a specific archive
	if(get_post_type($id) == 'archive'){
		$attachment_id = get_post_meta($id, 'video_file', true);
		$filename = wp_get_attachment_url(get_post_meta($id, 'video_file', true));
		$channel = get_post_meta($id, 'channel', true); 
	}
	//showing a channel
	else {
		$channel = $id;
		
		//if showing live player
		if(get_field('is_live', $id)) {	
			$filename = get_field('stream_key', $id);
			$live = true;
		} 
		//showing default archive
		else {
			//default archive is set
			$default_archive = get_post_meta($id, 'default_archive', true);
			if($default_archive) {
				$archive = $default_archive;
			} 
			//try to find an archive
			else {
				$archive_q = new WP_Query(array('post_type'=>'archive', 'meta_key'=>'channel', 'meta_value'=>$id, 'posts_per_page'=>1));
				if($archive_q->have_posts()){
					$archive = $archive_q->posts[0]->ID;
				}
				wp_reset_postdata();
			}
			//found an archive
			if($archive){
				$poster = wp_get_attachment_image_src(get_post_thumbnail_ID($archive), 'full');
				$poster = $poster[0];
				$attachment_id = get_post_meta($archive, 'video_file', true);
				$filename = basename(get_attached_file(get_post_meta($archive, 'video_file', true))); 
				$title = get_the_title($archive);
			}
		}	
	}
	
	if($filename){
		$http = false;
		$src = cltv_format_video_src($filename, $live, $http, $attachment_id);		
		$commercial_id = get_post_meta($id, 'commercial', true);	
		$commercial = false;
		if($commercial_id) {
			$commercial = get_post($commercial_id);
			if($commercial) {
				$attachment_id = get_post_meta($commercial->ID, 'commercial_video_file', true);
				$commercial = basename(get_field('commercial_video_file', $commercial->ID));
				$commercial = cltv_format_video_src($commercial, false, $http, $attachment_id);	
			}	
		}
		return array('src'=>$src, 'poster'=>$poster, 'title'=>$title, 'commercial'=>$commercial);
	} else return false;	
}

// Get an array of popular channels
function cltv_get_popular_channels($max = 25) {
	try {
		include_once('gapi.class.php');
		// create the GAPI object
		$email_address = 'info@citylinktv.com';
		$password = 'Joshua06';
		$ga =new gapi($email_address, $password);
		
		// set the filters
		$report_id = '50765226';
		$dimensions = array('pagePath');
		$metrics = array('pageviews');
		$sort = '-pageviews';
		$filter = 'ga:pagePath =@ /channel/';
		
		// make the request for popular url's
		$ga->requestReportData($report_id, $dimensions, $metrics, $sort, $filter, null, null, null, $max);
		$ga_results = $ga->getResults();
		
		// create an array of slugs
		$i = 0;
		$channels = false;
		foreach($ga_results as $path)
		{    
			$tokens = explode('/', $path->getPagePath());
			$slug = $tokens[2];
			if($slug != 'channel' && $slug != '' && $slug != 'profile')
			{
				$channels[$i] = $slug;	
				$i++;
			}			
		}		
		wp_reset_postdata();		
		return $channels;
	} catch (Exception $e) {
		return false;
	}
}

/* ------------------------------------------------------------------
|
|
|	Custom Queries
|
|
| -------------------------------------------------------------------*/

// Sort taxonomy pages by channel state
function channel_category_order( $query ){
	if(!is_admin()){
		//filter out private channels
		if(!$query->is_single && 
			isset($query->query_vars['post_type']) && 
            !isset($query->query_vars['author']) && 
			$query->query_vars['post_type'] == 'channel')
		{		
			$query->set('post_status', 'publish');
		}		
		if( $query->is_tax ){
			$query->set('post_type', 'channel');
			$query->set('meta_key', 'state');
			$query->set('orderby', 'meta_value');
			$query->set('order', 'ASC');
			$query->set('posts_per_page', '50');
		} elseif($query->is_search){
			$query->set('post_type', 'channel');
		} elseif($query->is_archive && isset($_GET['state'])){
			$query->set('meta_key', 'state');
			$query->set('meta_value', $_GET['state']);
			$query->set('posts_per_page', '50');
			$query->set('orderby', 'title');
			$query->set('order', 'ASC');
		}
		//lets the mobile navigation work without effecting desktop nav
		if(isset($_GET['state']) && !isset($_GET['category'])){
			$query->set('meta_key', 'state');
			$query->set('meta_value', $_GET['state']);
			$query->set('posts_per_page', '50');
			$query->set('orderby', 'title');
			$query->set('order', 'ASC');
		}
		//filter out channels for the events page
		if(isset($query->query_vars['post_type']) && 
			$query->query_vars['post_type'] == 'tribe_events' 
			&& isset($_GET['author_id']))
		{		
			$query->set('author', $_GET['author_id']);
		}
		return $query;
	}
}
add_action( 'pre_get_posts', 'channel_category_order' );

?>