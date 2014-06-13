<?php get_header(); 
	global $wp_query; 
	if($wp_query->max_num_pages > 1){
		$col = ($wp_query->query_vars['posts_per_page'] / 2) - 1;
	} else {
		$col = ($wp_query->found_posts / 2) - 1;
	}
	if($_GET['state']){
		$states = cltv_states();
		$the_title = $states[$_GET['state']] . ' Channels';
	} else {
		$the_title = wp_title('');
	}
?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span12 clearfix" role="main">					
					<div class="page-header"><h1 class="single-title" itemprop="headline"><?php echo $the_title; ?></h1></div>
					<div class="row-fluid">
						<div class="span6">
							<ul class="media-list">
								<?php $i = 1; if(have_posts()): while(have_posts()): the_post(); ?>						
									<li class="media">	
										<a class="pull-left" href="<?php the_permalink(); ?>">
											<?php if(has_post_thumbnail()): ?>
												<?php the_post_thumbnail('thumbnail'); ?>
											<?php else: ?>
												<img src="<?php echo get_template_directory_uri(); ?>/images/default_logo.png" alt="" />
											<?php endif; ?>		
										</a>	
										<div class="media-body">
											<h4 class="media-heading">
												<a href="<?php the_permalink(); ?>">
													<?php the_title(); ?>
												</a>
											</h4>
										</div>
									</li>	
									<?php if($i > $col): ?>
										</ul></div><div class="span6"><ul class="media">
									<?php endif; ?>
								<?php $i++; endwhile; ?>	
							</ul>
						</div>
					</div>
				</div><!-- end #main -->
				
				<div class="span12 clearfix">
					
					<?php if (function_exists('page_navi')) { // if expirimental feature is active ?>
						
						<?php page_navi(); // use the page navi function ?>

					<?php } else { // if it is disabled, display regular wp prev & next links ?>
						<nav class="wp-prev-next">
							<ul class="clearfix">
								<li class="prev-link"><?php next_posts_link(_e('&laquo; Older Entries', "bonestheme")) ?></li>
								<li class="next-link"><?php previous_posts_link(_e('Newer Entries &raquo;', "bonestheme")) ?></li>
							</ul>
						</nav>
					<?php } ?>
								
					
					<?php else : ?>
					
					<article id="post-not-found">
					    <header>
					    	<h1><?php _e("No Posts Yet", "bonestheme"); ?></h1>
					    </header>
					    <section class="post_content">
					    	<p><?php _e("Sorry, What you were looking for is not here.", "bonestheme"); ?></p>
					    </section>
					    <footer>
					    </footer>
					</article>
					
					<?php endif; ?>
			
				</div> 
    
			</div> <!-- end #content -->

<?php get_footer(); ?>