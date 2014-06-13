<?php
/*
Template Name: Homepage
*/
?>

<?php get_header(); ?>
			<div id="content" class="clearfix row-fluid">
				
				<div class="span3 hidden-phone">
					<?php $popular = cltv_get_popular_channels(59); ?>
					<?php if($popular): ?>
						<div class="row-fluid">
						
							<div class="span12">
								<h2>Most Viewed (30 Days)</h2>
								<ul class="media-list">
									<?php foreach($popular as $slug): ?>
										<?php $channel = new WP_Query(array('post_type'=>'channel', 'name'=>$slug, 'post__not_in'=>array(8832, 4125, 28427, 28705, 3953, 3913, 27487, 4183))); ?>
										<?php if($channel->have_posts()): while($channel->have_posts()): $channel->the_post(); ?>
											<li class="media">
												<a class="pull-left" href="<?php the_permalink(); ?>">
													<?php if(has_post_thumbnail()): ?>
														<?php the_post_thumbnail('thumbnail', array('class'=>'media-object')); ?>
													<?php else: ?>
														<img class="media-object" src="<?php echo get_template_directory_uri(); ?>/images/default_logo.png" alt="" />
													<?php endif; ?>
												</a>
												<div class="media-body">
													<h4 class="media-heading">
														<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
															<?php echo cltv_trim(get_the_title(), 25); ?>
														</a>
													</h4>
												</div>
											</li>
										<?php endwhile; endif; wp_reset_postdata(); ?>
									<?php endforeach;  ?>
								</ul>								
							</div>
													
						</div> 
					<?php endif; ?>	
				</div>
			
				<div id="main" class="span9 clearfix" role="main">
						
					<div class="hero-unit">
						<h1>City Link TV</h1>
						<h2>Watch live local events for free</h2>
						<?php $video = cltv_format_video_src(of_get_option('front_page_video')); ?>
						<?php /*echo do_shortcode(
							'[easysmp html5_src="'.$video['html5'].'"
							flash_src="'.$video['flash']. '"
							poster="'.of_get_option('front_page_video_poster').'" 
							width="400" 
							height="225"]'
						)*/ ?>	
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
								        skin: "bekle",
								        //title: "Welcome",
								        playlist: [{
								        	image: "<?php echo of_get_option('front_page_video_poster'); ?>",									        								        	
								        	sources: [{								        		
								        		file: "<?php echo $video['flash']; ?>",
								        	}, {
								        		file: "<?php echo $video['html5']; ?>"
								        	}]
								        }]
								    });
							    }
							});    
						</script>
						<div id="video"><a href="<?php echo $video['html5']; ?>">Tap here to watch video</a> </div>
 					
						<p>
							<a href="/about" class="btn btn-primary btn-large">Learn more</a>
							<a href="/register" class="btn btn-success btn-large">Get your own channel</a>
						</p>
					</div>
					
					<div class="row-fluid all_channels">
						<h2>Channels</h2>
						<?php $channels = new WP_Query(array(
							'post_type'=>'channel', 
							'meta_key'=>'state', 
							'orderby'=>'meta_value title', 
							'order'=>'ASC',
							'posts_per_page'=>-1,
							'post__not_in'=>array(8832,19206,4125,28427,28705),
                            'author__not_in'=>array(454)
						)); ?>
						<ul class="columnize" data-columns="3">
							<?php while($channels->have_posts()): $channels->the_post(); ?>
                                <?php if(get_the_ID() == 24755): ?>
                                    <li><a href="/stratus-vision"><?php the_field('state'); ?> - <?php the_title(); ?></a></li>
                                <?php continue; endif; ?>
								<?php if(get_field('state')): ?>
									<li><a href="<?php the_permalink(); ?>"><?php the_field('state'); ?> - <?php the_title(); ?></a></li>
								<?php endif; ?>
							<?php endwhile; ?>
						</ul>
					</div>
			
				</div> <!-- end #main -->
    
			</div> <!-- end #content -->
<?php get_footer(); ?>