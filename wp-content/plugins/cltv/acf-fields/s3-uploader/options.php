<tr class="field_option field_option_<?php echo $this->name; ?>">
<td class="label">
<label><?php _e("Default Value",'acf'); ?></label>
</td>
<td>
<?php
do_action('acf/create_field', array(
  'type'	=>	'text',
  'name'	=>	'fields[' .$key.'][default_value]',
  'value'	=>	$field['default_value'],
));
?>
</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
<td class="label">
<label><?php _e("Formatting",'acf'); ?></label>
<p class="description"><?php _e("Define how to render html tags",'acf'); ?></p>
</td>
<td>
<?php
do_action('acf/create_field', array(
  'type'	=>	'select',
  'name'	=>	'fields['.$key.'][formatting]',
  'value'	=>	$field['formatting'],
  'choices' => array(
    'none'	=>	__("None",'acf'),
    'html'	=>	__("HTML",'acf')
  )
));
?>
</td>
</tr>
