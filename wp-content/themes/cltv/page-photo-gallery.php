<?php
/*
Template Name: Photo Gallery
*/

$channel = isset($_GET['channelId']) ? $_GET['channelId'] : 0;
$photo_gallery = get_field('photo_gallery', $channel);

?>

<?php get_header(); ?>

			<div id="content" class="clearfix row-fluid">

				<div id="main" class="span12 clearfix" role="main">

					<?php if ($channel): ?>

            <?php if(count($photo_gallery)): ?>
          		<h1 class="page-header">Photo Gallery</h1>
          		<div class="row-fluid photo-gallery">
          			<?php $i=0; foreach($photo_gallery as $photo): ?>
          				<?php if($i>7) break; ?>
          				<div class="span3">
          					<a href="<?php echo $photo['url']; ?>">
          						<img class="img-responsive" src="<?php echo $photo['url']; ?>">
          					</a>
          			</div>
          			<?php $i++; endforeach; ?>
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

					<?php endif; ?>

				</div> <!-- end #main -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
