<?php namespace AgreablePollPlugin;

use AgreablePollPlugin\Helper;
// The helper cannot be used at the moment if more than one Herbetr plugin is present.
$ns = Helper::get('agreable_namespace');

/*
 * Although we're in the Herbert panel file, we're not using any built in
 * panel functionality because you have to write you're own HTML forms and
 * logic. We're using ACF instead but seems sensible to leave ACF logic in
 * here (??).
 */

acf_add_options_sub_page(array(
  'page_title'  => 'Style Settings',
  'menu_title'  => 'Poll Settings',
  'parent_slug' => 'edit.php?post_type=poll',
));

// Constructed using (lowercased and hyphenated) 'menu_title' from above.
$options_page_name = 'acf-options-poll-settings';

if( function_exists('register_field_group') ):

register_field_group(array (
  'key' => 'group_'.$ns.'_plugin',
  'title' => 'Display Settings',
  'fields' => array (
    array (
      'key' => $ns.'_plugin_field_settings_property_primary_color',
      'label' => 'Primary Colour',
      'name' => $ns.'_plugin_settings_property_primary_colour',
      'prefix' => '',
      'type' => 'color_picker',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '50%',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '#ff00ff',
    ),
    array (
      'key' => $ns.'_plugin_field_settings_property_secondary_colour',
      'label' => 'Secondary Colour',
      'name' => $ns.'_plugin_settings_property_secondary_colour',
      'prefix' => '',
      'type' => 'color_picker',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '50%',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '#ffffff',
    ),
    array (
      'key' => $ns.'_plugin_field_settings_property_font_family',
      'label' => 'Font Family',
      'name' => $ns.'_plugin_settings_property_font_family',
      'prefix' => '',
      'type' => 'text',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'maxlength' => '',
      'readonly' => 0,
      'disabled' => 0,
    ),
    array (
      'key' => $ns.'_plugin_field_settings_free_text_css',
      'label' => 'Extra CSS',
      'name' => $ns.'_plugin_settings_free_text_css',
      'prefix' => '',
      'type' => 'textarea',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'maxlength' => '',
      'rows' => '',
      'new_lines' => 'wpautop',
      'readonly' => 0,
      'disabled' => 0,
    ),
    array (
      'key' => $ns.'_plugin_field_settings_senti_user_id',
      'label' => 'Senti User ID',
      'name' => $ns.'_plugin_settings_senti_user_id',
      'prefix' => '',
      'type' => 'text',
      'instructions' => 'Generate by creating a Senti user account (https://senti.firebaseapp.com). For example \'simplelogin:22\'.',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'maxlength' => '',
      'readonly' => 0,
      'disabled' => 0,
    ),
    array (
      'key' => $ns.'_plugin_field_settings_firebase_secret',
      'label' => 'Senti / Firebase Secret Key',
      'name' => $ns.'_plugin_settings_firebase_secret',
      'prefix' => '',
      'type' => 'text',
      'instructions' => 'Available here: <a href="https://senti.firebaseio.com/?page=Admin">https://senti.firebaseio.com/?page=Admin</a>',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'maxlength' => '',
      'readonly' => 0,
      'disabled' => 0,
    ),
    array (
      'key' => $ns.'_plugin_field_'.$ns.'_facebook_app_id',
      'label' => 'Facebook App ID',
      'name' => $ns.'_plugin_settings_property_facebook_app_id',
      'prefix' => '',
      'type' => 'text',
      'instructions' => 'If not present then plugin will use JavaScript variable \'FB_APP_ID\' which is set in parent theme. ',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'maxlength' => '',
      'readonly' => 0,
      'disabled' => 0,
    ),
  ),
  'location' => array (
    array (
      array (
        'param' => 'options_page',
        'operator' => '==',
        'value' => $options_page_name,
      ),
    ),
  ),
  'menu_order' => 0,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => '',
));

endif;
