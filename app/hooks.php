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
