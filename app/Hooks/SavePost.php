<?php namespace AgreablePollPlugin\Hooks;

use Herbert\Framework\Notifier;
use AgreablePollPlugin\Helper;

class SavePost {

  public function init() {
    // Priority  of 20 means post will have already been saved.
    \add_action('acf/save_post', array($this, 'save_post'), 20);
    \add_filter('acf/save_post' , array($this, 'pre_save_post'), 9, 1 );

  }

  /*
   * Update the WP database from Firebase values before post is saved.
   * Then we have the latest values and can update answer text or ordering
   * in save_post().
   * We may still lose a couple of votes due to network latency during extremely
   * busy voting periods.
   * @author Gareth Foote
   */
  public function pre_save_post( $post_id ){

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
      return false;
    }
    $firebase = new \Firebase\FirebaseLib('https://senti.firebaseio.com/', $secret);

    $path = 'polls';

    $firebasePollId = get_field('agreable_poll_definition_firebase_id', $post_id);

    // Update votes from Firebase before saving post.
    $firebase_answers = json_decode($firebase->get($path.'/'.$userId.'/'.$firebasePollId.'/answers'));

    if(!$firebase_answers){
      return;
    }

    $rows = [];
    if(have_rows('poll_answers', $post_id)){
      while(have_rows('poll_answers', $post_id) ) {
        array_push($rows, the_row());
      }
    }

    // Modifying $_POST using previous index and values recently extracted from
    // firebase.
    $post_answers = $_POST['acf']['agreable_poll_definition_answers'];
    for($i=0; $i < count($post_answers); $i++){
      if($i < count($rows)){
        // Get previous index from DB.
        $previous_index = $rows[$i]['agreable_poll_definition_answers_answer_index'];
        if($previous_index == ""){
          $previous_index = $i;
        }
        $votes = isset($firebase_answers[$previous_index]->votes) ? $firebase_answers[$previous_index]->votes : 0;
        // Update post using old index to get correct votes from firebase answers.
        $_POST['acf']['agreable_poll_definition_answers'][$i]['agreable_poll_definition_answers_answer_votes'] = $votes;

        // Update DB to new index for next time but remove from post.
        unset($_POST['acf']['agreable_poll_definition_answers'][$i]['agreable_poll_definition_answers_answer_index']);
        update_post_meta($post_id, "poll_answers_{$i}_answer_index", $i);
      }
    }

    // Update number of entries.
    $firebase_entries = $firebase->get($path.'/'.$userId.'/'.$firebasePollId.'/entries');
    $_POST['acf']['agreable_poll_definition_entries'] = $firebase_entries;
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
      return false;
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
        'votes' => $answer['answer_votes']
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
