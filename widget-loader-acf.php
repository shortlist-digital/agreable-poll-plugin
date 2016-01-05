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
          'key' => 'widget_poll_width',
          'label' => 'Width',
          'name' => 'width',
          'prefix' => '',
          'type' => 'select',
          'instructions' => '',
          'required' => 1,
          'conditional_logic' => 0,
          'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => array (
            'medium' => 'Medium',
            'full' => 'Full'
          ),
          'default_value' => array (
            'medium'
          ),
          'allow_null' => 0,
          'multiple' => 0,
          'ui' => 0,
          'ajax' => 0,
          'placeholder' => '',
          'disabled' => 0,
          'readonly' => 0,
        ),
    ),
    'min' => '',
    'max' => '',
);

$widget_config["content-types"] = array('post'); // section, article
$widget_config["content-sizes"] = array('main'); // main, main-full-bleed, sidebar
