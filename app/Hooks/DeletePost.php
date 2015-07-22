<?php namespace AgreablePollPlugin\Hooks;

use AgreablePollPlugin\Helper;

class DeletePost {

  public function init() {
    \add_action('trash_poll', array($this, 'trashPoll'), 1, 1);
    \add_action('untrash_post', array($this, 'untrashPost'), 1, 1);
  }

  public function getPath($postId){
    $userId = get_field('slm_poll_plugin_settings_senti_user_id', 'options');
    $firebasePollId = get_field('slm_poll_definition_firebase_id', $postId);

    return "polls/$userId/$firebasePollId";
  }

  public function trashPoll($postId){
    $secret = get_field('slm_poll_plugin_settings_firebase_secret', 'options');
    $firebase = new \Firebase\FirebaseLib('https://senti.firebaseio.com/', $secret);

    $path = $this->getPath($postId);
    $firebase->update($path, array('trashed'=>true));
  }

  public function untrashPost($postId){
    $post = get_post($postId);
    if($post->post_type !== 'poll'){
      return;
    }

    $secret = get_field('slm_poll_plugin_settings_firebase_secret', 'options');
    $firebase = new \Firebase\FirebaseLib('https://senti.firebaseio.com/', $secret);

    $path = $this->getPath($postId);
    $firebase->update($path, array('trashed'=>false));
  }

}
