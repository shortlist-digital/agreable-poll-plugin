<?php

/**
 * @wordpress-plugin
 * Plugin Name:       SLM Poll Plugin
 * Plugin URI:        http://shortlistmedia.co.uk
 * Description:       Create custom polls.
 * Version:           0.1.0
 * Author:            Shortlist Media
 * Author URI:        http://shortlistmedia.co.uk
 * License:           MIT
 */

if(file_exists(__DIR__ . '/../../../../vendor/autoload.php')){
  require_once __DIR__ . '/../../../../vendor/autoload.php';
} else {
  require_once __DIR__ . '/vendor/autoload.php';
}

if(file_exists(__DIR__ . '/../../../../vendor/getherbert/framework/bootstrap/autoload.php')){
  require_once __DIR__ . '/../../../../vendor/getherbert/framework/bootstrap/autoload.php';
} else {
  require_once __DIR__ . '/vendor/getherbert/framework/bootstrap/autoload.php';
}
