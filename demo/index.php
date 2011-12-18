<?php

require_once __DIR__.'/config.php';
require_once __DIR__.'/../lib/Phroto.php';

$phr = new Phroto($phroto_config);

$phr->route();
