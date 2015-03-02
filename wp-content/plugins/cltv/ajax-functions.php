<?php 

// Setup ajaxurl
function cltv_ajaxurl() {
	?>
	<script type="text/javascript">
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	</script>
	<?php
	}
add_action('wp_head','cltv_ajaxurl');


// Check if user is logged in
function ajax_check_user_logged_in() {
    echo is_user_logged_in()?'yes':'no';
    die();
}
add_action('wp_ajax_is_user_logged_in', 'ajax_check_user_logged_in');
add_action('wp_ajax_nopriv_is_user_logged_in', 'ajax_check_user_logged_in');


// Get channel results for navbar
function ajax_get_channels() {
    remove_action( 'pre_get_posts', 'channel_category_order' );
	$args = array('post_type'=>'channel', 'orderby'=>'name', 'order'=>'ASC', 'posts_per_page'=>125);
	if($_POST['category']){
		$args['channel_cat'] = $_POST['category'];
	}
	if($_POST['state']){
		$args['meta_key'] = 'state';
		$args['meta_value'] = $_POST['state'];
	}
	$channels = new WP_Query($args);
	if($channels->have_posts()): ?>
		<ul class="columnize" data-columns="3">
			<?php while($channels->have_posts()): $channels->the_post(); ?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php endwhile; ?>
		</ul>
	<?php else: ?>
		<div class="alert alert-block">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>Oh Snap!</h4>
			No channels were found. Try modifying your search.
		</div>
	<?php endif;
	
	die();
}
add_action('wp_ajax_get_channels', 'ajax_get_channels');
add_action('wp_ajax_nopriv_get_channels', 'ajax_get_channels');


// Show user navbar tools if logged in
function ajax_navbar_tools() { 
	global $current_user;
	get_currentuserinfo();
	?>
    <ul class="nav pull-right">
		<li class="divider-vertical"></li>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="icon-user icon-white"></i>
				<?php echo $current_user->display_name; ?>
				<b class="caret"></b>
			</a>
			<ul class="dropdown-menu">
				<?php global $post; $original = $post; $channel_q = new WP_Query(array('post_type' => 'channel', 'author' => $current_user->ID)); ?>
				<?php if(current_user_can('edit_channels')): ?>		
					<?php if($channel_q->have_posts()): ?>
						<li class="nav-header">View:</li>	
						<?php while($channel_q->have_posts()): $channel_q->the_post(); ?>
							<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>														
						<?php endwhile; ?>
						<li class="divider"></li>
						<li class="nav-header">Edit:</li>	
						<?php while($channel_q->have_posts()): $channel_q->the_post(); ?>
							<li><a href="<?php echo admin_url("post.php?action=edit&post=".get_the_ID()); ?>"><?php the_title(); ?></a></li>
						<?php endwhile; ?>
					<?php else: ?>
						<li><a href="<?php echo admin_url("post-new.php?post_type=channel"); ?>">Create Your Channel</a></li>
					<?php endif; ?>												
				<?php endif; ?>		
				<?php $post = $original; wp_reset_postdata(); ?>
				<li class="divider"></li>
				<li><a href="<?php echo admin_url("index.php"); ?>">Dashboard</a></li>
				<li class="divider"></li>
				<li><a href="<?php echo admin_url("admin.php?page=wp-help-documents"); ?>">Help</a></li>
				<li class="divider"></li>
				<li><?php wp_loginout(); ?></li>
			</ul>
		</li>
	</ul> 
	<?php
    
	
	die();
}
add_action('wp_ajax_navbar_tools', 'ajax_navbar_tools');
add_action('wp_ajax_nopriv_navbar_tools', 'ajax_navbar_tools');


// Show loginout link in footer
function ajax_loginout() {
    wp_loginout();
    
	die();
}
add_action('wp_ajax_loginout', 'ajax_loginout');
add_action('wp_ajax_nopriv_loginout', 'ajax_loginout');