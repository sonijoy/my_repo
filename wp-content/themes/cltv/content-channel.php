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

<?php while (have_posts()) : the_post(); 	?>


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

	<?php if($banner): 

	?>
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
			<?php if($channel_video['src']): 
			
?>
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
                        autostart: true,
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
<?php
$paid_user= get_current_user_id( );
$paid_p=$_REQUEST['st'];

$paid_id=get_the_ID();
//$paid_user=$_GET['ur_id'];
//$cur_user=get_current_user_id( );
if(!empty($paid_p) && $paid_p=="Completed"){
		
		add_user_meta( $paid_user, 'paid_post_id', $paid_id); 

}


$paid=get_post_meta ( get_the_ID(),'paid',true );

if($paid==1){
	if(is_user_logged_in() ){
	$return_url= get_post_permalink();
	$user_id= get_current_user_id( );
	$post_id=get_the_ID();
	$channel_name=get_the_title( $post_id );
	$post_ids = $wpdb->get_col("SELECT DISTINCT(meta_value) FROM $wpdb->usermeta WHERE meta_key = 'paid_post_id' AND user_id = '" . $user_id . "'  " );
	 
	 if(in_array(get_the_ID(), $post_ids)){
	 	?>
	 	<div id="video">
<noscript>You must have javascript enabled to watch this video</noscript>
<a href="<?php echo $channel_video['src']['html5']; ?>">Tap here to watch video</a>
</div>
	 				<?php
	 				}
	 	else{
	 		
			$ret_url=$url."&po_id=".$post_id."&ur_id=".$user_id;	 			

		 	$amount=get_post_meta ($post_id,'amount',true );
			$currency=get_post_meta($post_id,'currency',true);
			$currency=strtoupper($currency);
			 $post_author_id = get_post_field( 'post_author', $post_id );
			 $user = get_user_by('id',$post_author_id );
			 
			 $paypal_email=get_post_meta($post_id,'paypal_email',true);
			?>
	 	<div id="paid" align="center" style="background-color: black; height: 350px; ">
	 			<div style="padding-top: 100px; font-size:18px; color:red;" ><b>This is a paid channel,You have to pay amount to watch this</b><br><br>
	 			<input style="text-align:center; width:80px;" readonly type= "text" name="amt" value="$<?php echo $amount ;?>">
				</div>
<div>				
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_xclick-subscriptions" />
		<input type="hidden" name="business" value="<?php echo $paypal_email; ?>">
		<input type="hidden" name="item_name" value="<?php echo $channel_name;?>">
		<input type="hidden" name="item_number" value="<?php echo $post_id;?>">
		<input type="hidden" name="lc" value="GB">
		<input type="hidden" name="no_note" value="1">
		<input type="hidden" name="src" value="1">
		<input type="hidden" name="a3" value="<?php echo $amount; ?>">
		<input type="hidden" name="p3" value="1">
		<input type="hidden" name="t3" value="M">
		<input type="hidden" name="no_shipping" value="0" />
        <input type="hidden" name="no_note" value="1" />
        <input type="hidden" name="mrb" value="3FWGC6LFTMTUG" />
        <input type="hidden" name="bn" value="IC_Sample" />
		<input type="hidden" name="currency_code" value="<?php echo $currency;?>">
		<input type="hidden" name="return" value="<?php echo get_post_permalink();?>" />
		<input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHostedGuest">
		<input type="image" src="https://www.paypal.com/en_AU/i/btn/btn_paynow_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
		<img alt="" border="0" src="https://www.paypal.com/en_AU/i/scr/pixel.gif" width="1" height="1">
		</form></div>
					

								
			 <?php  //echo Paypal_payment_accept($author_email,'USD',$amount,$ret_url);?>
			 		
			 	</div>
			 	<!--<script type="text/javascript">
				window.location='<?php echo $url; ?>';
			 	</script>-->
			 	
			 	<?php

			 		//echo "not paid";

					}
		}else{
					$red= home_url()."/wp-login.php"; 
					
				?>
				<script type="text/javascript">
						window.location='<?php echo $red; ?>';
					 	</script>

			<?php
		}}

				?>
				<?php else: ?>
					<div class="channel_offline"> Channel currently offline</div>
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
