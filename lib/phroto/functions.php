<?php

// Init template context. Do not use in templates.
function phroto_init_context($phr, $tpl) {
  global $phroto, $tpl_path;
  $phroto = $phr;
  $tpl_path = $tpl;
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

// Returns an URL
function url($path) {
  global $phroto;
  if ($phroto->tmp_mode === 'static') {
    return $path;
  } else {
    return $phroto->settings['base_url'].$path;
  }
}

// Returns the URL of a page (dynamic / static)
function page($path) {
  global $phroto, $tpl_path;
  if ($phroto->tmp_mode === 'static') {
    for ($i = substr_count($tpl_path, '/'); $i > 0; $i--) {
      $path = '../' . $path;
    }
    return url($path.'.html');
  } else {
    $path = str_replace('?', '&', $path);
    return url('?p='.$path);
  }
}

//
function img($path) {
  global $phroto;
}