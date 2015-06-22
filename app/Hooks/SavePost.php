<?php namespace SLM_PollPlugin\Hooks;

use SLM_PollPlugin\Helper;

class SavePost {

  public function init() {
    \add_action('acf/save_post', array($this, 'savePost'), 20);
  }

  public function savePost( $postId ){

    $post = get_post( $postId );
    if($post->post_type !== 'poll' ||
      isset($_POST['acf']) === false ){
      return;
    }

    $userId = get_field('slm_poll_plugin_settings_senti_user_id', 'options');
    $secret = get_field('slm_poll_plugin_settings_firebase_secret', 'options');
    $firebase = new \Firebase\FirebaseLib('https://senti.firebaseio.com/', $secret);

    $path = 'polls';
    $acf = $_POST['acf'];

    // Empty poll obj.
    $poll = array(
      'question'  => $acf['slm_poll_definition_question'],
      'userId'    => $userId,
      'answers'   => array(
        // array('text' => '', 'votes' => 0),
      )
    );

    // Loop through answers in ACF.
    foreach($acf['slm_poll_definition_answers'] as $acfAnswer){
      array_push($poll['answers'], array(
        'text' => $acfAnswer['slm_poll_definition_answers_answer_text'],
        'shareText' => ''
      ));
    }

    // Update or insert based on presence of firebase_id.
    if( isset($acf['slm_poll_definition_firebase_id']) &&
      empty($acf['slm_poll_definition_firebase_id']) === false){
      // Update.
      $firebaseId = $acf['slm_poll_definition_firebase_id'];
      $return = $firebase->update($path.'/'.$userId.'/'.$firebaseId, $poll);
    } else {
      // Insert.
      $poll['entries'] = 0;
      $poll['created_at'] = round(microtime(true) * 1000);
      $return = $firebase->push($path.'/'.$userId, $poll);
      // Insert object contains firebase id.
      $returnJSON = json_decode($return);
      update_field('slm_poll_definition_firebase_id', $returnJSON->name, $postId);
    }

  }

}
