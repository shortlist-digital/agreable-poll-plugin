<?php

namespace SLM_PollPlugin\Hooks;

use SLM_PollPlugin\Helper;

class SavePost {

  public function init() {
    \add_action('acf/save_post', array($this, 'savePost'), 20);
  }

  public function savePost( $postId ){

    $post = get_post( $postId );
    $path = 'polls';
    $userId = 'simplelogin:22';
    $secret = '0OfyumxYuH4nTWqKjW5oPmfhaXqAYMZnHB9AVqam';
    $firebase = new \Firebase\FirebaseLib('https://senti.firebaseio.com/', $secret);

    if($post->post_type !== 'poll' ||
      isset($_POST['acf']) === false ){
      return;
    }

    $acf = $_POST['acf'];

    // Empty poll obj.
    $poll = array(
      'question'  => $acf['slm_poll_definition_question'],
      'userId'    => 'custom:1',
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
