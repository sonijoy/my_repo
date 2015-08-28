<?php
/*
Template Name: Stratus Vision
*/

$channels = new WP_Query(array('post_type'=>'channel', 'author'=>454));
function the_title_trim($title)
{
  $pattern[0] = '/Protected:/';
  $pattern[1] = '/Private:/';
  $replacement[0] = ''; // Enter some text to put in place of Protected:
  $replacement[1] = ''; // Enter some text to put in place of Private:

  return preg_replace($pattern, $replacement, $title);
}
add_filter('the_title', 'the_title_trim');
?>
<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Stratus Vision</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon(s) in the root directory -->

        <link rel="stylesheet" href="/wp-content/themes/cltv/library/css/bootstrap.superhero.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <nav class="navbar navbar-default" role="navigation">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <a class="navbar-brand" href="#">Stratus Vision</a>
            </div>
          </div><!-- /.container-fluid -->
        </nav>
        
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="col-md-12">
                    <div class="page-header">
                      <h1>My Cameras</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php while($channels->have_posts()): 
                    $channels->the_post(); 
                    $src = cltv_format_video_src(get_field('stream_key'), true); ?>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                          <div class="panel-heading"><?php the_title(); ?></div>
                          <div class="panel-body">
                            <script src="http://jwpsrv.com/library/hskNKAMBEeOg6CIACusDuQ.js"></script>
                            <script>
                                $(document).ready(function(){
                                    var android = /Android/i.test(navigator.userAgent);
                                    if(android && navigator.mimeTypes["application/x-shockwave-flash"] == undefined) {
                                        //$('#video').html($('#android').html());			
                                    } else {
                                        var theplayer = jwplayer("video_<?php the_ID(); ?>").setup({
                                            primary: 'flash',
                                            aspectratio: "16:9",
                                            width: "100%",
                                            skin: "bekle",
                                            autostart: true,
                                            playlist: [ {
                                                sources: [{
                                                    file: "<?php echo $src['flash']; ?>",
                                                }, {
                                                    file: "<?php echo $src['html5']; ?>"
                                                }]
                                            }]
                                        });
                                    }
                                });     
                            </script>
                            <div id="video_<?php the_ID(); ?>">
                                <noscript>You must have javascript enabled to watch this video</noscript>
                                <a href="<?php echo $channel_video['src']['html5']; ?>">Tap here to watch video</a>
                            </div>
                          </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    </body>
</html>