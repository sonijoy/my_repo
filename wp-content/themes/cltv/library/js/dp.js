(function($){
	$(document).ready(function(){
		$('li#toplevel_page_back_to_home a').attr('href', '/');
		$('li#toplevel_page_custom_logout a').attr('href', '/wp-login.php?action=logout&_wpnonce=539ed2f13e&redirect_to=http%3A%2F%2Fbeta.citylinktv.com');
	});
})(jQuery);