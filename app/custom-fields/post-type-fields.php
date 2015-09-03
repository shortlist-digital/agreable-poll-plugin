<?php

if ( ! class_exists( 'ACF' ) ) {
  add_action( 'admin_notices', function() {
    echo '<div class="error"><p>ACF5 Pro is not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
  } );
  return;
}

if( function_exists('register_field_group') ):

register_field_group(array (
  'key' => 'agreable_poll_definition',
  'title' => 'Poll Definition',
  'fields' => array (
    array (
      'key' => 'agreable_poll_definition_entries',
      'label' => 'Entries',
      'name' => 'entries',
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
      'readonly' => 1,
      'disabled' => 0,
    ),
    array (
      'key' => 'agreable_poll_definition_answers',
      'label' => 'Answers',
      'name' => 'poll_answers',
      'prefix' => '',
      'type' => 'repeater',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'min' => '',
      'max' => '',
      'layout' => 'table',
      'button_label' => 'Add an answer',
      'sub_fields' => array (
        array (
          'key' => 'agreable_poll_definition_answers_answer_text',
          'label' => 'Answer / Button Text',
          'name' => 'answer_text',
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
          'key' => 'agreable_poll_definition_answers_answer_votes',
          'label' => 'Votes',
          'name' => 'answer_votes',
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
          'readonly' => 1,
          'disabled' => 0,
        ),
        array (
          'key' => 'agreable_poll_definition_answers_answer_index',
          'label' => 'Answer Index (Firebase)',
          'name' => 'answer_index',
          'prefix' => '',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => array (
            array (
              array (
                'field' => 'agreable_poll_definition_show_sentifirebase_settings',
                'operator' => '==',
                'value' => '1',
              ),
            ),
          ),
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
          'readonly' => 1,
          'disabled' => 0,
        ),
      ),
    ),
    array (
      'key' => 'agreable_poll_definition_firebase_id',
      'label' => 'Senti / Firebase Poll ID',
      'name' => 'firebase_id',
      'prefix' => '',
      'type' => 'text',
      'instructions' => 'Reference to remote Senti/Firebase database record. Used for updating Poll.',
      'required' => 0,
      'conditional_logic' => array (
        array (
          array (
            'field' => 'agreable_poll_definition_show_sentifirebase_settings',
            'operator' => '==',
            'value' => '1',
          ),
        ),
      ),
      'wrapper' => array (
        'width' => '',
        'class' => '',
        // 'class' => 'hidden-by-conditional-logic',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'maxlength' => '',
      'readonly' => 1,
      'disabled' => 1,
    ),
    array(
      'key' => 'agreable_poll_definition_show_sentifirebase_settings',
      'label' => 'Show Senti/Firebase details',
      'name' => 'show_sentifirebase_settings',
      'type' => 'true_false',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => 'extra-widget-settings',
        'id' => '',
      ),
      'choices' => array (
        '' => '',
      ),
      'default_value' => 0,
      'layout' => 'vertical',
    ),
    array (
      'key' => 'poll_definition_message',
      'label' => 'Previewing & Embedding',
      'name' => '',
      'type' => 'message',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'message' => 'To preview correctly you will need to publish first. Once happy with preview you can get the raw HTML by suffixing the URL with "embed". e.g. <b>http://embeds-local.shortlist.com/poll/what-is-your-favourite-cheese/embed</b> ',
      'esc_html' => 0,
    ),
  ),
  'location' => array (
      array (
          array (
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'poll',
          ),
      ),
  ),
  'menu_order' => 0,
  'position' => 'normal',
  'style' => 'seamless',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => '',
));

endif;
