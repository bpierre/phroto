<?php

// Init template context. Do not use in templates.
function phroto_init_context($phr) {
  global $phroto;
  $phroto = $phr;
}

// Set a layout
function layout($layout='_layout') {
  global $phroto;
  $phroto->tmp_layout = $layout;
}

// Returns a partial
function partial($name, $vars=array()) {
  global $phroto;
  //echo $phroto->render_template($partial_name, $vars, NULL, TRUE);
  foreach ($vars as $single_key => $single_var) {
    $$single_key = $single_var;
  }
  require $phroto->settings['tpl_dir'].'/_partials/'. $name .'.php';
}

// Print an URL
function url($path) {
  global $phroto;
  echo $phroto->settings['base_url'].$path;
}

// Returns the URL of a page (dynamic / static)
function page($path) {
  global $phroto;
  return ($phroto->tmp_mode === 'static')? url($path.'.html') : url('?p='.$path);
}

//
function img($path) {
  global $phroto;
}