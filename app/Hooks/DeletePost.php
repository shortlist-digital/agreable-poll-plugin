<?php namespace SLM_PollPlugin\Hooks;

use SLM_PollPlugin\Helper;

class SavePost {

  public function init() {
    // Priority  of 20 means post will have already been saved.
    // \add_action('acf/save_post', array($this, 'savePost'), 20);
    \add_action( 'delete_post', array($this, 'deletePost'), 10 );
  }

  public function deletePost( $postId ){

    $post = get_post( $postId );
    if($post->post_type !== 'poll' ||
      isset($_POST['acf']) === false ){
      return;
    }

    //Both user and secret set in the WP settings.
    $userId = get_field('slm_poll_plugin_settings_senti_user_id', 'options');
    $secret = get_field('slm_poll_plugin_settings_firebase_secret', 'options');
    $firebase = new \Firebase\FirebaseLib('https://senti.firebaseio.com/', $secret);

    $path = 'polls';

    $firebasePollId = get_field('slm_poll_definition_firebase_id', $postId);

    // Update or insert based on presence of firebase_id.
    // $return = $firebase->update($path.'/'.$userId.'/'.$firebasePollId, $poll);
    // $firebase->delete($path);

  }

}
