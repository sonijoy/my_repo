<div class="sidebar-channel-php">
	<?php if($sponsors->have_posts()): ?>
		<div class="sponsor" data-max="<?php echo $sponsors->post_count; ?>">
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

	<div class="row-fluid channel_details">
		<div class="span4">
			<a href="#">
				<?php echo get_the_post_thumbnail($channel, 'medium'); ?>
			</a>
		</div>
		<div class="span8">
			<h2>
				<?php if(get_field('is_live')): ?>
					<?php the_field('broadcast_title'); ?>
				<?php else: ?>
					<?php echo $channel_video['title']; ?>
				<?php endif; ?>
			</h2>
		</div>
	</div>

	<?php if(get_the_content() != ''): ?>
		<div class="row-fluid">
			<div class="span12">
				<?php the_content(); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php
		/*global $post;
		$author_email = get_the_author_meta('user_email',$post->post_author);
		if(!empty($author_email)):
	?>
		<div class="row-fluid">
			<div class="span12 contact_channel">
				<a href="#modal_contact" role="button" class="btn btn-primary" data-toggle="modal">Contact Channel</a>
				<div id="modal_contact" data-channel="<?php echo get_the_title($channel); ?>" data-author="<?php echo $author_email; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modal_contact_label" aria-hidden="true">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
						<h3 id="modal_contact_label">Contact Channel</h3>
					</div>
					<div class="modal-body">
						<?php //echo do_shortcode( '[contact-form-7 id="7755" title="Contact Channel"]' ); ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif;*/ ?>

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
				<a class="btn btn-primary btn-small" href="/events?author_id=<?php the_author_meta('ID'); ?>">Event Calendar</a>
			</div>
		</div>
	</div>

	<?php $archives = new WP_Query(array('posts_per_page'=>60, 'post_type'=>'archive','meta_key'=>'channel','meta_value'=>$channel)); ?>
	<?php if($archives->have_posts()): ?>
		<div class="row-fluid">
			<div class="span12">
				<h3>Archived Videos:</h3>
				<ul class="media-list archive-list">
					<?php while($archives->have_posts()): $archives->the_post(); ?>
						<li class="media">
							<a class="pull-left" href="<?php the_permalink(); ?>">
								<?php if(has_post_thumbnail()): ?>
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
		</div>
	<?php endif; wp_reset_postdata(); ?>
</div>
