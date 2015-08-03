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

  function create_field( $field )
  {
    global $post;
    $s3_attach_id = get_post_meta($post->ID,$field['_name'],true);
  	$s3_file = wp_get_attachment_url($s3_attach_id);

    include(dirname(__File__).'/template.php');
  }


  /*
  *  create_options()
  *
  *  Create extra options for your field. This is rendered when editing a field.
  *  The value of $field['name'] can be used (like bellow) to save extra data to the $field
  *
  *  @param	$field	- an array holding all the field's data
  *
  *  @type	action
  *  @since	3.6
  *  @date	23/01/13
  */

  function create_options( $field )
	{
    // vars
    $defaults = array(
      'default_value'	=>	'',
      'formatting' 	=>	'html',
    );

    $field = array_merge($defaults, $field);
    $key = $field['name'];

    require_once(dirname(__File__).'/options.php');
	}


  /*
  *  format_value()
  *
  *  This filter is appied to the $value after it is loaded from the db and before it is passed to the create_field action
  *
  *  @type	filter
  *  @since	3.6
  *  @date	23/01/13
  *
  *  @param	$value	- the value which was loaded from the database
  *  @param	$post_id - the $post_id from which the value was loaded
  *  @param	$field	- the field array holding all the field options
  *
  *  @return	$value	- the modified value
  */

  function format_value( $value, $post_id, $field )
  {
    $value = htmlspecialchars($value, ENT_QUOTES);

    return $value;
  }


  /*
  *  format_value_for_api()
  *
  *  This filter is appied to the $value after it is loaded from the db and before it is passed back to the api functions such as the_field
  *
  *  @type	filter
  *  @since	3.6
  *  @date	23/01/13
  *
  *  @param	$value	- the value which was loaded from the database
  *  @param	$post_id - the $post_id from which the value was loaded
  *  @param	$field	- the field array holding all the field options
  *
  *  @return	$value	- the modified value
  */

  function format_value_for_api( $value, $post_id, $field )
  {
    // vars
    $defaults = array(
      'formatting'	=>	'html',
    );

    $field = array_merge($defaults, $field);


    // validate type
    if( !is_string($value) )
    {
      return $value;
    }


    if( $field['formatting'] == 'none' )
    {
      $value = htmlspecialchars($value, ENT_QUOTES);
    }
    elseif( $field['formatting'] == 'html' )
    {
      $value = nl2br($value);
    }


    return $value;
  }

}

new acf_s3_uploader();

?>
