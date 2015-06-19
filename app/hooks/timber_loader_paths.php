<?php

/** @var  \Herbert\Framework\Application $container */

use SLM_PollPlugin\Helper;

/*
 * We want Timber to render our plugin templates so we need to
 * add our views onto the $paths array that Timber uses internally.
 * We do this using a Wordpress filter that Timber instantiates:
// @see https://github.com/jarednova/timber/blob/master/lib/timber-loader.php#L225
 */

// Called when Timber gets Twig loader.
add_filter('timber/loader/paths', 'addPaths');

/*
 * use with Timber filter 'timber/loader/paths' to add Herbert views to array
 * @param $paths array
 * @return $paths array
 */
function addPaths($paths){
  // Get views specified in herbert.
  $namespaces = Helper::get('views');
  foreach ($namespaces as $namespace => $views){
    foreach ((array) $views as $view){
      // Add to timber $paths array.
      array_unshift($paths, $view);
    }
  }
  return $paths;
}

// Other possible Timber filters below were used in attempts to access
// the TwigEnvironment object so we could add Twig namespaces. No luck.
// Leaving these here for the moment because they might be useful.

// Just before the file is rendered. Can bypass file selection here.
// add_filter('timber_render_file', 'add_paths');
// @see https://github.com/jarednova/timber/blob/master/timber.php#L285

// Passes an instance of Twig just before rendering but after tpl selection.
// add_filter('twig_apply_filters', 'update_twig_loader');
// @see https://github.com/jarednova/timber/blob/master/timber.php#L307


