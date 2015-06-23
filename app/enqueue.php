<?php namespace SLM_PollPlugin;

/** @var \Herbert\Framework\Enqueue $enqueue */

$enqueue->admin([
  'as'     => 'firebaseJS',
  'src'    => 'https://cdn.firebase.com/js/client/2.2.0/firebase.js',
  'filter' => [ 'hook' => 'edit.php' ]
], 'footer');

$enqueue->admin([
  'as'     => 'adminJS',
  'src'    => Helper::assetUrl('admin.js'),
  'filter' => [ 'hook' => 'edit.php' ]
], 'footer');

