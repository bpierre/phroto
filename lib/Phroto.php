<?php

class Phroto {
  public $settings;
  public $tmp_layout;
  public $tmp_vars = array();
  public $tmp_mode = NULL;

  public function __construct($settings=array()) {
    $this->settings = $this->get_settings($settings);
  }

  private function get_settings($settings) {
    return array_merge(array(
      'project_name' => 'Phroto',
      'tpl_dir' => __DIR__.'/../pages',
      'default_vars' => array(),
      'base_url' => '/',
      'output_dir' => __DIR__.'/../output',
      'auto_static' => FALSE,
      'pages_excludes' => array(),
    ), $settings);
  }

  public function route() {
    if (isset($_GET['p']) && $_GET['p'] !== '') {
      $output = $this->render_template($_GET['p'], $this->settings['default_vars']);
      if ($output === FALSE) {
        header("HTTP/1.0 404 Not Found");
        exit('<h1>The requested page ('.$_GET['p'].') does not exists</h1>');
      } else {
        echo $output;
      }
      if ($this->settings['auto_static']) {
        $this->tmp_mode = 'static';
        $output = $this->render_template($_GET['p'], $this->settings['default_vars']);
        $this->write_static_file($_GET['p'], $output);
      }
    } else {
      echo $this->render_index();
    }
  }

  public function generate_static() {
    $this->tmp_mode = 'static';
    $pages = $this->get_pages_list();
    foreach ($pages as $page) {
      $output = $this->render_template($page, $this->settings['default_vars']);
      $this->write_static_file($page, $output);
    }
  }

  private function render_index() {
    return $this->render_template('index', array(
      'pages' => $this->get_pages_list(),
      'project_name' => $this->settings['project_name'],
    ), __DIR__.'/phroto/tpl');
  }

  private function get_dir_files($dir) {
    $excludes = array_merge(array('.', '..'), $this->settings['pages_excludes']);
    $filtered = array_filter(scandir($dir), function($item) use (&$excludes, &$dir) {
      return !in_array($item, $excludes) &&
             $item[0] !== '_' &&
             $item[0] !== '.';
    });
    return $filtered;
  }

  private function get_pages_list($tpl_dir=NULL) {
    $files_list = array();
    if ($tpl_dir === NULL) {
      $tpl_dir = $this->settings['tpl_dir'];
    }
    $filtered_files = $this->get_dir_files($tpl_dir);

    foreach ($filtered_files as $file) {
      if (is_dir($tpl_dir.'/'.$file)) {
        $item = array(
          'name' => $file,
          'files' => $this->get_pages_list($tpl_dir.'/'.$file),
        );
      } else {
        $item = array(
          'name' => strstr($file, '.php', TRUE),
        );
      }
      array_push($files_list, $item);
    }

    return $files_list;
  }

  public function render_template($tpl_name, $vars=array(), $tpl_dir=NULL) {

    if ($tpl_dir === NULL) {
      $tpl_dir = $this->settings['tpl_dir'];
    }

    if (!file_exists($tpl_dir.'/'.$tpl_name.'.php')) {
      return FALSE;
    }

    foreach ($vars as $single_key => $single_var) {
      $$single_key = $single_var;
    }

    $project_name = $this->settings['project_name'];

    require_once __DIR__.'/phroto/functions.php';
    phroto_init_context($this, $tpl_name);

    ob_start();
    require $tpl_dir.'/'.$tpl_name.'.php';
    $output = ob_get_contents();
    ob_end_clean();

    if ($this->tmp_layout !== NULL) {
      ob_start();
      $content = $output;
      foreach ($this->tmp_vars as $key => $val) {
        $$key = $val;
      }
      $this->tmp_vars = array();
      require $tpl_dir.'/'.$this->tmp_layout.'.php';

      $output = ob_get_contents();
      ob_end_clean();
      $this->tmp_layout = NULL;
    }

    return $output;
  }

  private function write_static_file($page, $output) {
    if (strpos($page, '/') !== FALSE && !file_exists(dirname($this->settings['output_dir'] . '/' . $page))) {
      mkdir(dirname($this->settings['output_dir'] . '/' . $page), 0777, TRUE);
    }
    file_put_contents($this->settings['output_dir'].'/'. $page .'.html', $output);
  }
}
