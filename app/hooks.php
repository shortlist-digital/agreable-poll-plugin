<?php

/** @var  \Herbert\Framework\Application $container */

use SLM_PollPlugin\Hooks\TimberLoaderPaths;
use SLM_PollPlugin\Hooks\SavePost;

(new TimberLoaderPaths)->init();
(new SavePost)->init();
