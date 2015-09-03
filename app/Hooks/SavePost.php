<?php namespace AgreablePollPlugin\Hooks;

use Herbert\Framework\Notifier;
use AgreablePollPlugin\Helper;

class SavePost {

  public function init() {
    // Priority  of 20 means post will have already been saved.
    \add_action('acf/save_post', array($this, 'save_post'), 20);
  }

  public function save_post( $post_id ){

    $post = get_post( $post_id );
    if(
      $post_id == 'options' ||
      $post->post_type !== 'poll' ||
      isset($_POST['acf']) === false ){
      return;
    }

    //Both user and secret set in the WP settings.
    $userId = get_field('agreable_poll_plugin_settings_senti_user_id', 'options');
    $secret = get_field('agreable_poll_plugin_settings_firebase_secret', 'options');
    if(empty($secret) || empty($userId)){
      $pollsettings = get_admin_url( null, '/edit.php?post_type=poll&page=acf-options-poll-settings');
      return;
    }
    $firebase = new \Firebase\FirebaseLib('https://senti.firebaseio.com/', $secret);

    $path = 'polls';
    $acf = $_POST['acf'];

    // Empty poll obj.
    $poll = array(
      'question'  => html_entity_decode(get_the_title($post_id), ENT_QUOTES, 'UTF-8'),
      'userId'    => $userId,
      'answers'   => array(
        // array('text' => '', 'votes' => 0),
      )
    );

    $answers = get_field('agreable_poll_definition_answers', $post_id);
    // Loop through answers in ACF.
    foreach($answers as $answer){
      array_push($poll['answers'], array(
        'text' => $answer['answer_text'],
        'shareText' => '',
        'votes' => 0
      ));
    }

    $firebasePollId = get_field('agreable_poll_definition_firebase_id', $post_id);
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
      update_field('agreable_poll_definition_firebase_id', $returnJSON->name, $post_id);
    }

  }

}
