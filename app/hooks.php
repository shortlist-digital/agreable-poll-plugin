<?php

/** @var  \Herbert\Framework\Application $container */

use SLM_PollPlugin\Hooks\TimberLoaderPaths;
use SLM_PollPlugin\Hooks\SavePost;

if(class_exists('SLM_PollPlugin\Hooks\TimberLoaderPaths')){
  (new TimberLoaderPaths)->init();
}

if(class_exists('SLM_PollPlugin\Hooks\SavePost')){
  (new SavePost)->init();
}

/*
 * Custom placeholder for poll post type.
 */
add_filter('enter_title_here','custom_enter_title');
if( function_exists('custom_enter_title') ){

  function custom_enter_title( $input ) {
    global $post_type;

    if(is_admin() && 'Enter title here' == $input && $post_type === 'poll'){
      return __('Enter poll question');
    }

    return $input;
  }

}
