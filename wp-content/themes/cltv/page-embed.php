<?php
/*
Template Name: Channel Embed
*/
define( 'DONOTCACHEPAGE', true );
?>

<?php if(isset($_GET['id'])): ?>

<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body>

	<style>
		html, html body { background:none; overflow:hidden; margin:0; padding:0; width:100%; height:100%; }
	</style>

	<?php $id = $_GET['id']; ?>
	<?php $channel_video = cltv_channel_video($id); ?>
	<?php if($channel_video['src']): ?>
		<?php if(get_field('is_live')) $stream_type = 'live'; else $stream_type = 'recorded'; ?>
		<script src="http://jwpsrv.com/library/hskNKAMBEeOg6CIACusDuQ.js"></script>
		<script>
			$(document).ready(function(){
				var android = /Android/i.test(navigator.userAgent);
				if(android && navigator.mimeTypes["application/x-shockwave-flash"] == undefined) {
					//$('#video').html($('#android').html());
					} else {
						var theplayer = jwplayer("video").setup({
								primary: 'flash',
								aspectratio: "16:9",
								width: "100%",
								//height: "100%",
								skin: "bekle",
								<?php if($stream_type == 'live'): ?>
										autostart: true,
								<?php endif; ?>
								playlist: [<?php if(!empty($channel_video['commercial']['html5'])): ?>{
									image: "<?php echo $channel_video['poster']; ?>",
									sources: [<?php if($channel_video['commercial']['flash']): ?>{
										file: "<?php echo $channel_video['commercial']['flash']; ?>"
									},<?php endif; ?> {
										file: "<?php echo $channel_video['commercial']['html5']; ?>"
									}]
								},<?php endif; ?> {
									image: "<?php echo $channel_video['poster']; ?>",
									sources: [<?php if($channel_video['src']['flash']): ?>{
										file: "<?php echo $channel_video['src']['flash']; ?>"
									},<?php endif; ?> {
										file: "<?php echo $channel_video['src']['html5']; ?>"
									}]
								}]
						});
					}
			});
		</script>
		<div id="video">
			<noscript>You must have javascript enabled to watch this video</noscript>
			<a href="<?php echo $channel_video['src']['html5']; ?>">Tap here to watch video</a>
		</div>
	<?php else: ?>
		<div class="channel_offline">Channel currently offline</div>
	<?php endif; ?>

	<?php wp_footer(); // js scripts are inserted using this function ?>
</body>
</html>

<?php endif; ?>
