<?php namespace AgreablePollPlugin\Hooks;

use AgreablePollPlugin\Helper;

class SavePost {

  public function init() {
    // Priority  of 20 means post will have already been saved.
    \add_action('acf/save_post', array($this, 'savePost'), 20);
  }

  public function savePost( $postId ){

    $post = get_post( $postId );
    if($post->post_type !== 'poll' ||
      isset($_POST['acf']) === false ){
      return;
    }

    //Both user and secret set in the WP settings.
    $userId = get_field('agreable_poll_plugin_settings_senti_user_id', 'options');
    $secret = get_field('agreable_poll_plugin_settings_firebase_secret', 'options');
    $firebase = new \Firebase\FirebaseLib('https://senti.firebaseio.com/', $secret);

    $path = 'polls';
    $acf = $_POST['acf'];


    // Empty poll obj.
    $poll = array(
      'question'  => html_entity_decode(get_the_title($postId), ENT_QUOTES, 'UTF-8'),
      'userId'    => $userId,
      'answers'   => array(
        // array('text' => '', 'votes' => 0),
      )
    );

    $answers = get_field('agreable_poll_definition_answers', $postId);
    // Loop through answers in ACF.
    foreach($answers as $answer){
      array_push($poll['answers'], array(
        'text' => $answer['answer_text'],
        'shareText' => '',
        'votes' => 0
      ));
    }

    $firebasePollId = get_field('agreable_poll_definition_firebase_id', $postId);
    // Update or insert based on presence of firebase_id.
    if( empty($firebasePollId) === false ){
      // Update.
      $return = $firebase->update($path.'/'.$userId.'/'.$firebasePollId, $poll);
    } else {
      // Insert.
      $poll['entries'] = 0;
      $poll['created_at'] = round(microtime(true) * 1000);
      $return = $firebase->push($path.'/'.$userId, $poll);
      // Insert object contains firebase id.
      $returnJSON = json_decode($return);
      update_field('agreable_poll_definition_firebase_id', $returnJSON->name, $postId);
    }

  }

}
