<?php

require_once __DIR__.'/Phroto.php';

$phr = new Phroto(array(
  'base_url' => '',
  'output_dir' => __DIR__.'/../output',
));

$phr->generate_static();