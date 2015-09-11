<?php

// $config = require_once 'herbert.config.php';
// $ns = $config['agreable_namespace'];

$widget_config = array (
    'key' => 'widget_poll',
    // The 'name' will define the directory that the parent theme looks
    // for our plugin template in. e.g. views/widgets/quiz_plugin/template.twig.
    'name' => 'poll_plugin',
    'label' => 'Poll',
    'display' => 'block',
    'sub_fields' => array (
        array (
            'key' => 'widget_poll_poll_post',
            'label' => 'Select a Poll',
            'name' => 'poll_post',
            'prefix' => '',
            'type' => 'post_object',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'post_type' => array (
                0 => 'poll',
            ),
            'taxonomy' => '',
            'allow_null' => 0,
            'multiple' => 0,
            'return_format' => 'object',
            'ui' => 1,
        ),
        array (
          'key' => 'poll_quiz_contain',
          'label' => 'Contain within central column',
          'name' => 'contain',
          'instructions' => 'Relies on the presence of a CSS class of container in the parent theme.',
          'type' => 'true_false',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'message' => '',
          'default_value' => 1,
        ),
    ),
    'min' => '',
    'max' => '',
);

$widget_config["content-types"] = array('post'); // section, article
$widget_config["content-sizes"] = array('main'); // main, main-full-bleed, sidebar
