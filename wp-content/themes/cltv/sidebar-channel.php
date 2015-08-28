<div class="sidebar-channel-php">
	<?php if($sponsors->have_posts()): ?>
		<h2 class="widget">Sponsor</h2>
		<div class="sponsor">
			<?php $i=1; while($sponsors->have_posts()): $sponsors->the_post(); ?>
				<?php if(!get_field('banner_ad')): ?>
					<div class="row-fluid" data-sponsor="<?php echo $i; ?>">
						<div class="span12">
							<a href="<?php the_field('sponsor_url'); ?>">
								<?php if(has_post_thumbnail()): ?>
									<?php the_post_thumbnail('large'); ?>
								<?php else: ?>
									<?php the_title(); ?>
								<?php endif; ?>
							</a>
						</div>
					</div>
				<?php $i++; endif; ?>
			<?php endwhile; ?>
		</div>
	<?php else: ?>
		<div class="row-fluid">
			<a href="#" class="span12 sponsor thumbnail">
				Your ad could go here
			</a>
		</div>
	<?php endif; wp_reset_postdata(); ?>

	<h2 class="widget">Channel Info</h2>
	<div class="row-fluid channel_details">
			<a href="#">
				<?php echo get_the_post_thumbnail($channel, 'medium'); ?>
			</a>
			<h4>
				<?php if(get_field('is_live')): ?>
					<?php the_field('broadcast_title'); ?>
				<?php else: ?>
					<?php echo $channel_video['title']; ?>
				<?php endif; ?>
			</h4>
	</div>

	<?php if(get_the_content() != ''): ?>
		<div class="row-fluid">
			<div class="span12">
				<?php the_content(); ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="row-fluid">
		<div class="span12">
			<div class="social">
				<?php if(get_field('facebook_page')): ?>
					<a href="<?php the_field('facebook_page'); ?>">
						<img src="<?php echo get_template_directory_uri(); ?>/images/facebook.png" alt="Facebook" />
					</a>
				<?php endif; ?>
				<?php if(get_field('twitter_page')): ?>
					<a href="<?php the_field('twitter_page'); ?>">
						<img src="<?php echo get_template_directory_uri(); ?>/images/twitter.png" alt="twitter" />
					</a>
				<?php endif; ?>
				<?php if(get_field('google_plus_page')): ?>
					<a href="<?php the_field('google_plus_page'); ?>">
						<img src="<?php echo get_template_directory_uri(); ?>/images/google.png" alt="google_plus" />
					</a>
				<?php endif; ?>
				<?php if(get_field('pintrest_page')): ?>
					<a href="<?php the_field('pintrest_page'); ?>">
						<img src="<?php echo get_template_directory_uri(); ?>/images/pintrest.png" alt="pintrest" />
					</a>
				<?php endif; ?>
				<a class="btn btn-primary btn-small" href="/events/month/?author_id=<?php the_author_meta('ID'); ?>">Event Calendar</a>
			</div>
		</div>
	</div>

	<?php if($archives['All']->have_posts()): ?>
		<h2 class="widget">Archives</h2>
		<div class="row-fluid">
			<div class="span12">

				<ul class="nav nav-tabs">
					<?php foreach($archives as $cat => $archive_query): ?>
						<?php if($archive_query->have_posts()): ?>
							<li class="<?php if($cat == 'All') echo 'active'; ?>">
								<a a href="#archive-<?php echo $cat; ?>" data-toggle="tab">
									<label class="radio">
									  <input type="radio" name="archiveCategories"
												id="archiveCategories-<?php echo $cat; ?>"
												value="<?php echo $cat; ?>"
												<?php if($cat == 'All') echo 'checked'; ?>>
												<?php echo $cat; ?>
									</label>
								</a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>

				<div class="tab-content">

					<?php foreach($archives as $cat => $archive_query): ?>
						<?php if($archive_query->have_posts()): ?>

							<div class="tab-pane <?php if($cat == 'All') echo 'active'; ?>" id="archive-<?php echo $cat; ?>">
								<ul class="media-list archive-list">
									<?php while($archive_query->have_posts()): $archive_query->the_post(); ?>
										<li class="media">
											<a class="pull-left" href="<?php the_permalink(); ?>">
												<?php if(has_post_thumbnail() && get_the_post_thumbnail()): ?>
													<?php the_post_thumbnail('thumbnail'); ?>
												<?php else: ?>
													<img src="<?php echo get_template_directory_uri(); ?>/images/default_logo.png" alt="" />
												<?php endif; ?>
											</a>
											<div class="media-body">
												<div class="media-heading">
													<p>
														<a href="<?php the_permalink(); ?>">
															<?php echo cltv_trim(get_the_title(), 28); ?>
														</a>
													</p>
												</div>
											</div>
										</li>
									<?php endwhile; ?>
								</ul>
							</div>

						<?php endif; ?>
					<?php endforeach; ?>

				</div>

			</div>
		</div>
	<?php endif; wp_reset_postdata(); ?>

	<?php if(is_array($photo_gallery) && count($photo_gallery)): ?>
		<h2 class="widget">Photos</h2>
		<div class="row-fluid photo-gallery">
			<?php $i=0; foreach($photo_gallery as $photo): ?>
				<?php if($i>7) break; ?>
				<div class="span6">
					<a href="">
						<img class="img-responsive" src="<?php echo $photo['url']; ?>">
					</a>
			</div>
			<?php $i++; endforeach; ?>
		</div>
		<?php if(count($photo_gallery) > 2): ?>
			<a class="span12 text-center" href="<?php echo $photo_gallery_url; ?>">See All</a>
		<?php endif; ?>
	<?php endif; ?>

</div>
