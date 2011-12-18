<?php

require_once __DIR__.'/../config.php';
require_once __DIR__.'/Phroto.php';
require_once __DIR__.'/../helpers.php';

$phr = new Phroto($phroto_config);

$phr->generate_static();