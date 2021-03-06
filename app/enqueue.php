<?php namespace AgreablePollPlugin;

/** @var \Herbert\Framework\Enqueue $enqueue */

$enqueue->admin([
  'as'     => 'firebaseJS',
  'src'    => 'https://cdn.firebase.com/js/client/2.2.0/firebase.js',
  'filter' => [ 'hook' => 'edit.php' ]
], 'footer');

$enqueue->admin([
  'as'     => 'pollAdminJS',
  'src'    => Helper::assetUrl('admin.js'),
  'filter' => [ 'hook' => 'edit.php' ]
], 'footer');

