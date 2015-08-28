<?php
/*
Template Name: Get Channels
*/

remove_action( 'pre_get_posts', 'channel_category_order' );
$args = array('post_type'=>'channel', 'orderby'=>'name', 'order'=>'ASC', 'posts_per_page'=>125);
if($_GET['category']){
	$args['channel_cat'] = $_GET['category'];
}
if($_GET['state']){
	$args['meta_key'] = 'state';
	$args['meta_value'] = $_GET['state'];
}
$channels = new WP_Query($args);
?>

<?php if($channels->have_posts()): ?>
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
<?php endif; ?>