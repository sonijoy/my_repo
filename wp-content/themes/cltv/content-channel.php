<?php

	// get the channel
	global $post;
	$channel=$post->ID;
	if(get_post_type() == 'archive'){
		$channel=get_post_meta($channel, 'channel', true);
	}
	// channel's banner image
	$banner = new WP_Query(array(
		'post_type'=>'sponsor',
		'meta_query'=>array(
			array(
				'key'=>'channel',
				'value'=>"$channel"
			),
			array(
				'key'=>'banner_ad',
				'value'=>'1'
			)
		),
		'post_status'=>'published',
		'posts_per_page'=>1
	));
	$banner = $banner->have_posts() ? $banner->posts[0] : false;

	// channel video
	$channel_video = cltv_channel_video($post->ID);
	if(get_field('is_live', $channel)) {
		$stream_type = 'live';
	}
	else {
		$stream_type = 'recorded';
	}

	// message board
	$message_board = get_field('message_board', $channel);

	// sponsors
	$sponsors = new WP_Query(array(
		'post_type'=>'sponsor',
		'meta_key'=>'channel',
		'meta_value'=>$channel,
		'posts_per_page'=>30
	));

	// get archive terms
	$archive_terms = get_terms('archive_cat', array('hide_empty' => 0));
	$archive_term_names = array();
	$archives = array();

	// find all archives
	$archives['All'] = new WP_Query(array(
		'posts_per_page'=>60,
		'post_type'=>'archive',
		'meta_query' => array(array(
			'key'=>'channel',
			'value'=>$channel
		))
	));

	// find all archives in categories
	foreach($archive_terms as $term) {
		// build an array of slugs for the non-category archives
		array_push($archive_term_names, $term->name);

		$archives[$term->name] = new WP_Query(array(
			'posts_per_page'=>60,
			'post_type'=>'archive',
			'meta_query' => array(array(
				'key'=>'channel',
				'value'=>$channel
			)),
			'tax_query' => array(array(
		    'taxonomy' => 'archive_cat',
		    'field' => 'name',
		    'terms' => $term->name
			))
		));
	}

	$photo_gallery = get_field('photo_gallery', $channel);
	$photo_gallery_url = home_url('/photo-gallery?channelId='.$channel);

	wp_reset_postdata();
?>

<?php get_header(); ?>

	<div id="content" class="clearfix row-fluid content-channel">

		<div id="main" class="span9 clearfix well" role="main">

			<?php if (have_posts()): ?>

				<?php while (have_posts()) : the_post(); ?>

					<div id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

						<div class="row-fluid">
							<div class="span12">
								<ul class="breadcrumb">
									<li><?php the_terms($channel, 'channel_cat'); ?></li>
									<li><span class="divider">/</span></li>
									<li>
										<a href="/channel/?state=<?php echo get_field('state', $channel); ?>">
											<?php echo get_field('state', $channel); ?>
										</a>
									</li>
									<li><span class="divider">/</span></li>
									<li>
										<a href="<?php echo get_permalink($channel); ?>">
											<?php echo get_the_title($channel); ?>
										</a>
									</li>
								</ul>
							</div>
						</div>

						<?php if($banner): ?>
							<div class="row-fluid">
								<a class="span12 top_spons" target="_blank" href="<?php echo get_field('sponsor_url', $banner->ID); ?>">
										<?php echo get_the_post_thumbnail($banner->ID, 'full'); ?>
								</a>
							</div>
						<?php else: ?>
							<div class="row-fluid">
								<a class="span12 top_spons thumbnail" href="/contact">
									Your ad could go here
								</a>
							</div>
						<?php endif; ?>

						<!-- Video player -------------------------------------------------------------------->
						<div class="row-fluid">
							<div class="span12">
								<?php  ?>
								<?php if($channel_video['src']): ?>
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
							</div>
						</div>
						<!-- /video player -------------------------------------------------------------------->

						<div class="row-fluid">
							<?php if($message_board): ?>
								<h3>Message Board:</h3>
								<p><?php echo $message_board; ?></p>
							<?php endif; ?>
						</div>

					</div>

				<?php endwhile; ?>

					<?php if($sponsors->have_posts()): ?>
						<h2 class="widget">Sponsors</h2>
						<div class="sponsor_list">
							<div class="row-fluid">
								<ul class="thumbnails">
									<?php while($sponsors->have_posts()): $sponsors->the_post(); ?>
										<?php if(!get_field('banner_ad')): ?>
											<li class="span4">
												<a href="<?php the_field('sponsor_url'); ?>" class="thumbnail">
													<?php if(has_post_thumbnail()): ?>
														<?php the_post_thumbnail('large'); ?>
													<?php else: ?>
														<?php the_title(); ?>
													<?php endif; ?>
													<br><?php the_ID(); ?>
												</a>
											</li>
										<?php endif; ?>
									<?php endwhile; ?>
								</ul>
							</div>
						</div>
					<?php endif; ?>

			<?php else : ?>

				<article id="post-not-found">
					<header>
						<h1><?php _e("Not Found", "bonestheme"); ?></h1>
					</header>
					<section class="post_content">
						<p><?php _e("Sorry, but the requested resource was not found on this site.", "bonestheme"); ?></p>
					</section>
					<footer>
					</footer>
				</article>

			<?php endif; //if have post ?>

		</div> <!-- end #main -->

		<div id="channel-side" class="span3">
			<?php include(TEMPLATEPATH . '/sidebar-channel.php'); ?>
		</div>

	</div> <!-- end #content -->

<?php get_footer(); ?>
