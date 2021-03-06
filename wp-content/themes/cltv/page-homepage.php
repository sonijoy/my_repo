<?php
/*
Template Name: Homepage
*/

$popular = cltv_get_popular_channels(62);
$video = cltv_format_video_src(of_get_option('front_page_video'));
$channels = new WP_Query(array(
	'post_type'=>'channel',
	'meta_key'=>'state',
	'orderby'=>'meta_value title',
	'order'=>'ASC',
	'posts_per_page'=>-1,
	'post__not_in'=>array(8832,19206,4125,28427,28705),
								'author__not_in'=>array(454)
));
if(of_get_option('use_wowza_cdn')) {
	$wowza_base = of_get_option('wowza_cdn');
} else {
	$wowza_base = of_get_option('wowza_server');
}
?>

<?php get_header(); ?>
			<div id="content" class="clearfix row-fluid">
				<div class="span3 hidden-phone">
					<div class="tab-content">
						<?php //if($popular): ?>
							<div class="row-fluid tab-pane fade in active" id="popular-content">
								<div class="span12">
									<h2>Most Viewed (30 Days)</h2>
                                  
                                  
									<!--<ul class="media-list">-->
										<?php 
										// hiding this until we have data 
										//wpp_get_mostpopular( 'post_type="channel"&limit=50&title_length=23&range=monthly&thumbnail_width=35&thumbnail_height=35&post_html="<li>{thumb} <a href=\'{url}\'>{text_title}</a></li>"' ); ?>
                                  
                                    
                                    <ul class="media-list">
										<?php foreach($popular as $slug): ?>
											<?php $channel = new WP_Query(array('post_type'=>'channel', 'name'=>$slug)); ?>
											<?php
											if($channel->have_posts()): while($channel->have_posts()):
												$channel->the_post();
												$archives = get_posts(array('posts_per_page'=>1, 'post_type'=>'archive','meta_key'=>'channel','meta_value'=>get_the_ID()));
												if($archives && get_the_ID() != 3953):
											?>
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
											<?php endif; endwhile; endif; wp_reset_postdata(); ?>
										<?php endforeach;  ?>
									</ul>
									<!--</ul>-->
								</div>

							</div>
						<?php// endif; ?>
					</div>
				</div>

				<div id="main" class="span9 clearfix" role="main">

					<div class="hero-unit">
						<h1>City Link TV</h1>
						<h2>Watch live local events for free</h2>
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
								        	image: "http://uploads.citylinktv.com/poster.jpg",
								        	sources: [/*{
								        		file: "rtmp://rtmpuploads.citylinktv.com/cfx/st/intro2.mp4",
								        	},*/ {
								        		file: "<?php echo $wowza_base; ?>vods3/_definst_/mp4:amazons3/cltv-archives/intro2.mp4/playlist.m3u8"
								        	}]
								        }]
								    });
							    }
							});
						</script>
						<div id="video"><a href="<?php echo $wowza_base; ?>vods3/_definst_/mp4:amazons3/cltv-archives/intro2.mp4/playlist.m3u8">Tap here to watch video</a> </div>

						<p>
							<a href="<?php echo get_site_url()."/about" ?>"class="btn btn-primary btn-large">Learn more</a>
							<a href="<?php echo get_site_url()."/register"; ?>" class="btn btn-success btn-large">Get your own channel</a>
						</p>
					</div>

					<div class="row-fluid all_channels">
						<h2>Channels</h2>
                        <div class="clearfix"></div>
						<ul class="columnize" data-columns="3">
							<?php
							 $statearr = array();
							 $field = get_field_object('field_6');
							 $states = $field['choices'];

							 while($channels->have_posts()): $channels->the_post(); 
        					?>

                                <!--<?php if(get_the_ID() == 24755): ?>
                                    <li><a href="/stratus-vision"><?php the_field('state'); ?> - <?php the_title(); ?></a></li>
                                <?php continue; endif; ?> -->

									<?php if ($field = get_field('state')): ?>

									<?php 
										if(!in_array($field, $statearr)){
											if (!empty($statearr)) echo "</div>";
											echo '<div class="well">';
											echo '<li id="state">'.$states[$field].'</li>';
											$statearr[] = $field;
										}
									?>
											
									<li>
                                      <a href="<?php the_permalink(); ?>">
										<?php //the_field('state'); ?>  <?php the_title(); ?>
								      </a>
									</li>

									<?php endif; ?>

							<?php endwhile; ?>
						</div>
						</ul>
					</div>

				</div> <!-- end #main -->

			</div> <!-- end #content -->
<?php get_footer(); ?>
