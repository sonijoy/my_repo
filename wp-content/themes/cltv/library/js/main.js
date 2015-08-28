(function($) {
	$(document).ready(function(){
		/*----------------------------------------------
		|
		|	Global
		|
		------------------------------------------------*/

		//detect iOS/Android
		var is_mobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent);

		//load columnizer
		Modernizr.load([{
			test: Modernizr.csscolumns,
			nope: ['/wp-content/themes/wordpress-bootstrap/library/js/jquery.columnizer.js'],
			callback: function(){
				homepage_columns();
			}
		},{
			test: Modernizr.input.placeholder,
			nope: ['/wp-content/themes/wordpress-bootstrap/library/js/jquery.placeholder.min.js'],
			callback: function(){
				$('input, textarea').placeholder();
				console.log('placeholder');
			}
		}
		]);

		//run logged in user functions
		var logged_in = false;
		$.post(ajaxurl, {action:'is_user_logged_in'}, function(response) {
			if(response == 'yes'){
				logged_in = true;
				get_navbar_tools();
			}
			fix_body_class(logged_in);
			get_footer_login();
		});

		//make video wrapper dynamically sized
		if($('.easysmp_wrapper').length != 0){
			$('.easysmp_wrapper').on('DOMNodeInserted', function(){
				set_video_height();
			});
			if($('html.ie8, html.ie7').length == 0){
				window.onresize = set_video_height();
			}
		}

		//keep channels menu open on click
		$('.navbar .channels').not('.channel').click(function(e) {
			e.stopPropagation();
		});

		//update channels from category
		$('.navbar .channels .channel_cat a').click(function(e) {
			$('.navbar .channels .channel_cat li').removeClass('active');
			$(this).parents('li').addClass('active');
			if($('.navbar .channels select').val()){
				updateNavChannels();
			}
			e.stopPropagation();
			e.preventDefault();
		});

		//update channels from state
		$('.navbar .channels select').change(function(e) {
			if($('.navbar .channels .channel_cat .active').length == 1 && $(this).val()){
				updateNavChannels();
			}
		});

		/*----------------------------------------------
		|
		|	page-homepage.php
		|
		------------------------------------------------*/

		if($('body.page-template-page-homepage-php').length != 0){

			if(!is_mobile){
				$('body.page-template-page-homepage-php ul.thumbnails').mCustomScrollbar({
					scrollButtons:{enable:true},
					advanced:{updateOnContentResize: true},
					theme:"dark-2",
					horizontalScroll:true
				});
			}

		}

		/*----------------------------------------------
		|
		|	content-channel.php
		|
		------------------------------------------------*/

		if($('.content-channel').length != 0){

			// Pick a random sidebar sponsor to show
			if($('.sidebar-channel-php .sponsor .row-fluid').length != 0){
				var max = $('.sidebar-channel-php .sponsor .row-fluid').length;
				var active = Math.floor((Math.random()*max)+1);
				$('.sidebar-channel-php .sponsor').find('[data-sponsor="'+active+'"]').show();
			}

			// Rotate the sponsor rows every 30 seconds
			if($('.sponsor_list .thumbnail').length != 0){
				if($('html.ie8, html.ie7').length != 0){
					sponsors_margin();
				}
				setInterval(rotate_sponsors, 30000);
			}

			// Setup the channel contact form
			if($('.contact_channel').length != 0){
					$('input#author').val($('#modal_contact').data('author'));
					$('input#channel').val($('#modal_contact').data('channel'));
			}

			//Hide password-protected channel
			if($('form.post-password-form').length != 0) {
				$('#main').hide();
				$('.social').hide();
				$('.sponsor').hide();
			}

			// select the archive category tabs
			$('.sidebar-channel-php a[data-toggle="tab"]').on('shown', function (e) {
			  e.target // activated tab
			  e.relatedTarget // previous tab
				console.log(e.target);
				$(e.target).find('input[type=radio]').prop("checked", true);
			});
		}

		/*----------------------------------------------
		|
		|	functions
		|
		------------------------------------------------*/

		function homepage_columns(){
			if($('body.page-template-page-homepage-php').length != 0){
				$('.all_channels ul.columnize').columnize({ columns: 3 });
			}
		}

		function get_footer_login(){
			$.post(ajaxurl, {action:'loginout'}, function(response) {
				$('footer #inner-footer p').prepend(response);
			});
		}

		function fix_body_class(logged_in){
			if(logged_in){
				if(!$('body').hasClass('logged-in')){
					$('body').addClass('logged-in');
				}
			} else {
				if($('body').hasClass('logged-in')){
					$('body').removeClass('logged-in');
				}
			}
		}

		function get_navbar_tools(){
			$.post(ajaxurl, {action:'navbar_tools'}, function(response) {
				$('header .nav-collapse .navbar_tools').replaceWith(response);
			});
		}

		function sponsors_margin(){
			$('.sponsor_list li').css('margin-left','');
			$('.sponsor_list li:nth-child(3n + 4)').css('margin-left','0px');
		}

		function rotate_sponsors(){
			var $list = $('.sponsor_list ul');
			var $sponsors = $list.find('li').slice(-3);

			$sponsors.fadeTo('slow', 0, function(){
				$sponsors.prependTo($list);
				if($('html.ie8, html.ie7').length != 0){
					sponsors_margin();
				}
				$sponsors.fadeTo('slow', 1);
			});
		}

		function set_video_height(){
			$object = $('.easysmp_wrapper object');
			$video = $('.easysmp_wrapper video');
			$width = $('.easysmp_wrapper').parent().width();
			$object.height($width * 0.5625);
			$video.height($width * 0.5625);
		}

		function updateNavChannels(){
			data = { action:'get_channels', category:$('.navbar .channels .channel_cat .active a').data('category'), state:$('.navbar .channels select').val() };
			if(is_mobile){
				var link = '/channel/?channel_cat='+data.category+'&state='+data.state;
				$('.navbar .channels .ajax_loader').show();
				window.location = link;
				return false;
			}
			beforeSend = function(){
				$('.navbar .channels .ajax_loader').show();
			};
			complete = function(){
				$('.navbar .channels .ajax_loader').hide();
				$('.navbar .channels .results').show('slow', function(){
					if(!Modernizr.csscolumns && $('.navbar .channels .results li').length > 0){
						$('.navbar .channels .results .columnize').columnize({ columns: $('.navbar .channels .results .columnize').data('columns') });
						$('.navbar .channels .results li').css('list-style-type', 'none');
					}
				});
			};
			success = function(data){
				$('.navbar .channels .results').html(data);
				$('.navbar .channels .results').mCustomScrollbar({
					scrollButtons:{enable:true},
					advanced:{updateOnContentResize: true},
					theme:"dark-2"
				});
			};
			error = function(){
				$('.navbar .channels .results').html('Error finding channels');
			};
			$.ajax({
				beforeSend:beforeSend,
				type:'POST',
				complete:complete,
				success:success,
				error:error,
				data:data,
				url:ajaxurl
			});
		}
	});
})(jQuery);
