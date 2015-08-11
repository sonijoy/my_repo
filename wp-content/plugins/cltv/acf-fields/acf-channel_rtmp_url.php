<?php

class acf_ChannelRtmpUrl extends acf_field
{

	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/

	function __construct()
	{
		// vars
		$this->name = 'channel_rtmp_url';
		$this->label = __("RTMP URL",'acf');


		// do not delete!
    	parent::__construct();
	}



	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function render_field( $field )
	{
		global $post;
        $server = get_post_meta($post->ID, 'wowza_server', true);      
		$message = 'RTMP URL is:<br> rtmp://stream';
      
		if($server) {
          $message .= '-' . $server;       
        }
           
        $message .= '.citylinktv.com/livepkgr';
      
		echo $message;
	}
}

new acf_ChannelRtmpUrl();

?>
