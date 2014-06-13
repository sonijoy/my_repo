<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/library/js/jquery.strobemediaplayback.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/library/js/swfobject.js"></script>
<script type="text/javascript">
	$(function(){
		var options = {
			src: "http://players.edgesuite.net/videos/big_buck_bunny/bbb_448x252.mp4",
			width: 400,
            height: 300
		};
		
		var $video = $(".strobemediaplayback").strobemediaplayback(options);
		
		$video.bind("durationchange", onDurationChange);
		$video.bind("timeupdate", onTimeUpdate);
	});	
	function onDurationChange(event)
	{		
		$("#duration").html(this.duration);
	}
	function onTimeUpdate(event)
	{
		$("#currentTime").html(this.currentTime);
	}
</script>

<div class="video_wrapper">
	<div class="strobemediaplayback" 
				id="strobemediaplayback"
				data-smp-src="http://players.edgesuite.net/videos/big_buck_bunny/bbb_448x252.mp4"
				data-smp-width="480"
				data-smp-height="362"
				data-smp-poster="images/poster.png"
				data-smp-favorFlashOverHtml5Video="false">Alternative content</div>
</div>
<span id="currentTime" /> ... </span> : <span id="duration" /> ... </span>

<?php if($video): ?>
	<?php if(isset($video->is_live) && $video->is_live) {
		$video->src = 'rtmp://stream.citylinktv.com/livepkgr/'.$video->stream_key.'?adbe-live-event='.$video->stream_key.'event';
		$video->auto_play = 'false';
		$video->stream_type = 'live';
		$video->mobile_src = 'http://stream.citylinktv.com/hls-live/livepkgr/_definst_/'.$video->stream_key.'event/'.$video->stream_key.'.m3u8';
	} else {
		$video->src = 'rtmp://stream.citylinktv.com/vod/mp4:'.$video->filename;
		$video->auto_play = 'false';
		$video->stream_type = 'recorded';
		$video->mobile_src = 'http://stream.citylinktv.com/hls-vod/'.$video->filename.'.m3u8';	
	} /* ?>
	<div class="video_wrapper <?php echo $video->stream_type; ?>">
		<object type="application/x-shockwave-flash" data="http://fpdownload.adobe.com/strobe/FlashMediaPlayback.swf"> 
			<param name="movie" value="http://fpdownload.adobe.com/strobe/FlashMediaPlayback.swf">
			<param name="flashvars" value="src=<?php echo $video->src; ?>&autoPlay=<?php echo $video->auto_play; ?>&streamType=<?php echo $video->stream_type; ?>&poster=<?php echo $video->poster; ?>">
			<param name="allowFullScreen" value="true">
			<param name="allowscriptaccess" value="always">
			<param name="wmode" value="transparent">
			<video src="<?php echo $video->mobile_src; ?>" controls="controls" poster="<?php echo $video->poster; ?>"></video>
		</object>
	</div>
<?php */ else: ?>
	nothin'
<?php endif; ?>