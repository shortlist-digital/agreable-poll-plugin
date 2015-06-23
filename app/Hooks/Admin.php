<?php namespace SLM_PollPlugin\Hooks;

use Herbert\Framework\Notifier;
use SLM_PollPlugin\Hooks\TimberLoaderPaths;
use SLM_PollPlugin\Hooks\SavePost;

use Firebase\Token\TokenException;
use Firebase\Token\TokenGenerator;

class Admin {

  public function init() {
    // unset($_SESSION['firebase_token']);
    \add_action("admin_print_scripts-edit.php", array($this, 'addFirebaseToken'));
    \add_action('wp_ajax_get_firebase_path', array($this, 'get_firebase_path'));
    \add_filter('manage_poll_posts_columns', array($this, 'poll_menu_columns'));
  }

  public function poll_menu_columns($defaults) {
    $defaults['entries'] = 'Entries';
    return $defaults;
  }

  public function get_firebase_path() {
    global $wpdb; // this is how you get access to the database

    $post_id = intval($_POST['post_id']);
    $user_id = get_field('slm_poll_plugin_settings_senti_user_id', 'options');
    $senti_id = get_field('firebase_id', $post_id);

    echo "polls/$user_id/$senti_id";

    wp_die();
  }

  public function renderFirebaseToken($token){
    echo "<script> var firebase_JWT = '$token'; </script>";
  }

  public function addFirebaseToken(){

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

    $secret = get_field('slm_poll_plugin_settings_firebase_secret', 'options');
    $user = get_field('slm_poll_plugin_settings_senti_user_id', 'options');
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
