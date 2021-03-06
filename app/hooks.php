<?php

/** @var  \Herbert\Framework\Application $container */

use Herbert\Framework\Notifier;
use AgreablePollPlugin\Hooks\PluginEnqueue;
use AgreablePollPlugin\Hooks\TimberLoaderPaths;
use AgreablePollPlugin\Hooks\SavePost;
use AgreablePollPlugin\Hooks\DeletePost;
use AgreablePollPlugin\Hooks\Admin;


if(class_exists('AgreablePollPlugin\Hooks\TimberLoaderPaths')){
  (new TimberLoaderPaths)->init();
}

if(class_exists('AgreablePollPlugin\Hooks\PluginEnqueue')){
  (new PluginEnqueue)->init();
}

if(class_exists('AgreablePollPlugin\Hooks\SavePost')){
  (new SavePost)->init();
}

if(class_exists('AgreablePollPlugin\Hooks\DeletePost')){
  (new DeletePost)->init();
}

if(class_exists('AgreablePollPlugin\Hooks\Admin')){
  (new Admin)->init();
}

/*
 * Custom placeholder for poll post type.
 */
add_filter('enter_title_here','custom_enter_title');
if(function_exists('custom_enter_title') === false){
  function custom_enter_title($input) {
    global $post_type;

    if(is_admin() && 'Enter title here' == $input && $post_type === 'poll'){
      return __('Enter poll question');
    }

    return $input;
  }
}
