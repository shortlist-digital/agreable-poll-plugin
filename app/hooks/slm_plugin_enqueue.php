<?php

/** @var  \Herbert\Framework\Application $container */

use AgreablePollPlugin\Controllers\RenderController;

function enqueue(){
  $r = new RenderController();
  $r->enqueue();
}

// This action is called by widget-container.twig in parent theme and
// constructed from the widgeACF widget_config name. e.g. 'quiz_plugin'.
// Like so: add_action('agreable_{{acf_fc_layout}}_render', 'render');
add_action('agreable_quiz_plugin_enqueue', 'enqueue');
