<?php namespace AgreablePollPlugin\Controllers;

use AgreablePollPlugin\Helper;

class RenderController {

  /*
   * Output preview. Necessary for UTF8 encoding of quotes, etc.
   */
  public function preview($slug){

    echo <<<HTML
<!doctype html>
<html lang="">
  <head>
      <meta charset="utf-8">
  </head>
  <body>
HTML;

    $this->embed($slug);

    echo <<<HTML
    </body>
</html>
HTML;

  }

  public function embed($slug){

    $post = get_posts("name=$slug&post_type=poll");

    if(! $post || count($post) == 0){
      throw new \RuntimeException('Poll doesn\'t exist with this slug');
    }
    $context = \Timber::get_context();
    $context['poll'] = new \TimberPost($post[0]);

    $this->inline_css();
    $views = trailingslashit(Helper::get('views')['AgreablePollPlugin']);
	  \Timber::render("$views/widgets/poll_plugin/template.twig", $context);
    $this->inline_js();

  }

  /*
   * Enqueue scripts rather than render immediately. Used by widget iterator
   * to ensure that this is output in the footer after the themes app.js, which
   * will contain dependencies such as Backbone and jQuery.
   *
   * Due to using in the embed CMS context we now output Backbone and jquery into
   * the built JavaScript file so it contains all dependencies. Therefore we
   * could just output app.js here. Not doing that right now though.
   */
  public function enqueue_js(){

    // Enqueue scripts.
    wp_enqueue_script( 'agreable_poll_script', Helper::assetUrl('client.js'), array(), '1.0.0', true );

    $this->render_js_vars();

  }

  public function render_js_vars(){

    $ns = Helper::get('agreable_namespace');
    $facebook_app_id = get_field($ns.'_plugin_settings_property_facebook_app_id', 'option');

    echo "<script>";
    if(!empty($facebook_app_id)){
      // Rendered by plugin. Overrides theme FB_APP_ID if present.
      echo "var FB_APP_ID = '$facebook_app_id';";
    }
    echo "</script>";

  }

  /*
   * Output built CSS into a <style> tag inline.
   */
  public function inline_css(){

    /*
     * @AgreablePollPlugin is a Twig namespace which Herbert generates from
     * values in herbert.config.php.
     * @see http://twig.sensiolabs.org/doc/api.html#loaders
     *
     * Using get_field() which is an ACF function to retrieve theme
     * specific options affecting the style of the quiz.
     * ACF definitions for Panel are in app/panels.php.
     */
    $ns = Helper::get('agreable_namespace');
    echo view('@AgreablePollPlugin/styles.twig', [
        'common_css_path'   => Helper::asset('styles.css'),
        'plugin_settings_property_primary_colour'      => get_field($ns.'_plugin_settings_property_primary_colour', 'option'),
        'plugin_settings_property_secondary_colour'    => get_field($ns.'_plugin_settings_property_secondary_colour', 'option'),
        'plugin_settings_property_font_family'         => get_field($ns.'_plugin_settings_property_font_family', 'option'),
        'plugin_settings_free_text'                    => get_field($ns.'_plugin_settings_free_text_css', 'option'),
    ])->getBody();
  }

  /*
   * Output build JS into a <script> tag inline.
   */
  public function inline_js(){

    $this->render_js_vars();
    $js = file_get_contents(Helper::asset('client.js'));
    echo view('@AgreablePollPlugin/scripts.twig', [
        'js_path'   => Helper::asset('client.js'),
        'js'   => $js,
    ])->getBody();

  }

}
