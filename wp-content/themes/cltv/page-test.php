<?php
/*
Template Name: Test Page
*/
?>

<?php get_header(); ?>

<script src="http://jwpsrv.com/library/hskNKAMBEeOg6CIACusDuQ.js"></script>
<script>
	$(document).ready(function(){
		var android = /Android/i.test(navigator.userAgent);
		if(android && navigator.mimeTypes["application/x-shockwave-flash"] == undefined) {
			$('#video').html($('#android').html());			
	    } else {
	    	var theplayer = jwplayer("video").setup({
		        //primary: 'flash',
		        skin: "bekle",
		        playlist: [{
		        	image: "http://beta.citylinktv.com/uploads-misc/poster.jpg",
		        	sources: [{
		        		file: "rtmp://stream.citylinktv.com/livepkgr/fortsmith?adbe-live-event=fortsmithevent",
		        	}, {
		        		file: "http://stream.citylinktv.com/hls-live/livepkgr/_definst_/fortsmithevent/fortsmith.m3u8"
		        	}]
		        }]
		    });
	    }
	});    
</script>
<script id="android" type="text/html">
	<video controls preload="auto" width="640" height="264" poster="http://beta.citylinktv.com/uploads-misc/poster.jpg">
	 	<source src="http://stream.citylinktv.com/hls-live/livepkgr/_definst_/fortsmithevent/fortsmith.m3u8" />
	</video>
</script>
<div id="video"></div>
 

<?php /*echo do_shortcode(
	'[easysmp html5_src="http://stream.citylinktv.com/hls-vod/intro2.mp4.f4m"
	flash_src="http://stream.citylinktv.com/hds-vod/intro2.mp4.f4m"
	poster="'.of_get_option('front_page_video_poster').'" 
	width="400" 
	height="225"]'
)*/ ?>	
						
<?php get_footer(); ?>