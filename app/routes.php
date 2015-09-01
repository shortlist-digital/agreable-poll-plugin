<?php namespace AgreablePollPlugin;
/** @var \Herbert\Framework\Router $router */

$router->get([
  'as'   => 'poll',
  'uri'  => '/poll/{slug}/embed',
  'uses' => __NAMESPACE__ . '\Controllers\RenderController@embed'
]);

$router->get([
  'as'   => 'poll_preview',
  'uri'  => '/poll/{slug}/preview',
  'uses' => __NAMESPACE__ . '\Controllers\RenderController@preview'
]);

