<?php namespace AgreablePollPlugin\Hooks;

use Herbert\Framework\Notifier;
use AgreablePollPlugin\Hooks\TimberLoaderPaths;
use AgreablePollPlugin\Hooks\SavePost;

use Firebase\Token\TokenException;
use Firebase\Token\TokenGenerator;

class Admin {

  public function init() {
    // unset($_SESSION['firebase_token']);
    \add_action("admin_print_scripts-edit.php", array($this, 'add_firebase_token'));
    \add_action('wp_ajax_get_firebase_path', array($this, 'get_firebase_path'));
    \add_action('wp_ajax_update_poll', array($this, 'update_poll'));
    \add_filter('manage_poll_posts_columns', array($this, 'poll_menu_columns'));
    \add_filter('admin_head', array($this, 'missing_settings'));
  }

  public function missing_settings() {
    $screen = get_current_screen();
    if($screen->post_type !== 'poll'){
      return;
    }

    $user = get_field('agreable_poll_plugin_settings_senti_user_id', 'options');
    $secret = get_field('agreable_poll_plugin_settings_firebase_secret', 'options');
    if(empty($secret) || empty($user)){
      $pollsettings = get_admin_url( null, '/edit.php?post_type=poll&page=acf-options-poll-settings');
      $missing = empty($secret) ? "'Firebase secret'" : '';
      $missing .= (empty($secret) === true && empty($user) === true) ? ' and ' : '';
      $missing .= empty($user) ? "'Senti User ID'" : '';
      Notifier::error("Your are missing settings, which will cause Polls to not function correctly ($missing). Please visit <a href='$pollsettings'>Poll Settings</a> page and contact the digital operations team if necessary.");
      return;
    }

  }

  public function get_firebase_path() {
    $post_id = intval($_POST['post_id']);
    $user_id = get_field('agreable_poll_plugin_settings_senti_user_id', 'options');
    $senti_id = get_field('firebase_id', $post_id);

    echo "polls/$user_id/$senti_id";

    wp_die();
  }

  public function update_poll(){
    $post_id = intval($_POST['post_id']);
    $poll = $_POST['poll'];

    // print_r($poll['answers']);
    update_field('agreable_poll_definition_entries', $poll['entries'], $post_id);

    if(have_rows('poll_answers', $post_id)){
      $i = 0;
      while(have_rows('poll_answers', $post_id) ) {
        $row = the_row();
        foreach($poll['answers'] as $poll_answer){
          $row_text = $row['agreable_poll_definition_answers_answer_text'];
          if($poll_answer['text'] === $row_text){
            // Update.
            $votes = empty($poll_answer['votes']) ? 0 : $poll_answer['votes'];
            $row['agreable_poll_definition_answers_answer_votes'] = $votes;
            $return = update_post_meta($post_id, "poll_answers_{$i}_answer_votes", $votes);
          }
        }
        $i++;
      }
    }

    wp_die();
  }

  public function poll_menu_columns($defaults) {
    $defaults['entries'] = 'Entries';
    return $defaults;
  }

  public function renderFirebaseToken($token){
    echo "<script> var firebase_JWT = '$token'; </script>";
  }

  public function add_firebase_token(){

    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    // If exists and session is not active.
    if(isset($_SESSION['firebase_token'])){
      $token_obj = unserialize($_SESSION['firebase_token']);
      $ttl = $token_obj['ttl'];
      if(time() < $ttl){
        // echo "<script> var firebase_JWT = '{$token_obj['token']}'; </script>";
        $this->renderFirebaseToken($token_obj['token']);
        return;
      }
    }

    if(get_post_type() !== 'poll'){
      return;
    }

    $secret = get_field('agreable_poll_plugin_settings_firebase_secret', 'options');
    $user = get_field('agreable_poll_plugin_settings_senti_user_id', 'options');
    if(empty($secret) || empty($user)){
      $missing = empty($secret) ? "'Firebase secret'" : '';
      $missing .= (empty($secret) === true && empty($user) === true) ? ' and ' : '';
      $missing .= empty($user) ? "'Senti User ID'" : '';
      Notifier::warning("Your are missing settings, which will cause Polls to not function correctly ($missing). Please contact the development/digital team.");
      return;
    }

    // include_once "FirebaseToken.php";
    $token_generator = new \Services_FirebaseTokenGenerator($secret);
    $token = $token_generator->createToken(array("uid" => $user));
    $_SESSION['firebase_token'] = serialize(array(
      'ttl' => time()+(60*60*24),
      'token' => $token
    ));

    $this->renderFirebaseToken($token);

  }

}
