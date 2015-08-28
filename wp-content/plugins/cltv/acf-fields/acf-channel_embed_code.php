<?php

class acf_ChannelEmbed extends acf_field
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
		$this->name = 'channel_embed';
		$this->label = __("Embed Code",'acf');


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
		$embed_url = 'http://citylinktv.com/channel-embed?nonav=1&id='.$post->ID;
		$embed_code = '<iframe src="'.$embed_url.'" width="630" height="350" style="overflow:hidden; border:none;"></iframe>';
		echo "<input id='channel_embed' type='text' readonly='true' value='$embed_code' />";
	}
}

new acf_ChannelEmbed();

?>
