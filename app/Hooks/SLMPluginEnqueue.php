<?php namespace AgreablePollPlugin\Hooks;

use AgreablePollPlugin\Controllers\RenderController;

class SLMPluginEnqueue {

  public function init() {
    \add_action('slm_poll_plugin_enqueue', array($this, 'enqueue'));
  }

  public function enqueue($paths){
    $r = new RenderController();
    $r->enqueue();
  }

}

