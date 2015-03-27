<?php

class acf_s3_uploader extends acf_field
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
    $this->name = 's3_uploader';
    $this->label = __("S3 Uploader",'acf');
    $this->category = 'basic';
    $this->defaults = array(
			'font_size'	=> 14,
		);
    $this->l10n = array();


    // do not delete!
      parent::__construct();
  }



  /*
  *  render_field()
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
    $s3_attach_id = get_post_meta($post->ID,$field['_name'],true);
  	$s3_file = wp_get_attachment_url($s3_attach_id);

    include(dirname(__File__).'/template.php');
  }

}

new acf_s3_uploader();

?>
