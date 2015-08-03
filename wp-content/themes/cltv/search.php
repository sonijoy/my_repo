<?php get_header(); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span8 clearfix" role="main">
				
					<div class="page-header"><h1><span><?php _e("Search Results for","bonestheme"); ?>:</span> <?php echo esc_attr(get_search_query()); ?></h1></div>
					
					<ul class="media-list">	
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								<li class="media">	
									<a class="pull-left" href="<?php the_permalink(); ?>">
										<?php if(has_post_thumbnail()): ?>
											<?php the_post_thumbnail(); ?>
										<?php else: ?>
											<img src="<?php echo get_template_directory_uri(); ?>/images/default_logo.png" alt="" />
										<?php endif; ?>		
									</a>	
									<div class="media-body">
										<h4 class="media-heading">
											<a href="<?php the_permalink(); ?>">
												<?php the_field('state'); ?> - <?php the_title(); ?>
											</a>
										</h4>
									</div>
								</li>	
						<?php endwhile; ?>	
					</ul>
					
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
					
					<!-- this area shows up if there are no results -->
					
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
					
					<?php endif; ?>
			
				</div> <!-- end #main -->
    			
    			<?php get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- end #content -->

<?php get_footer(); ?>