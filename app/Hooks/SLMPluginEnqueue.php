<?php namespace AgreablePollPlugin\Hooks;

use AgreablePollPlugin\Controllers\RenderController;

class SLMPluginEnqueue {

  public function init() {
    \add_action('agreable_poll_plugin_enqueue', array($this, 'plugin_assets'), 10, 0);
  }

  public function plugin_assets(){
    $r = new RenderController();
    // JavaScript is enqueued (instead of rendered inline) so that it is called
    // after the markup is rendered.
    $r->enqueue_js();
    // CSS can be rendered inline just before the markup.
    $r->inline_css();
  }

}

