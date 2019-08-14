<?php

mb_internal_encoding("utf-8");
date_default_timezone_set('Europe/Moscow');
error_reporting(E_ALL);

require_once __DIR__ . '/src/Autoload.php';

(new Autoload(require_once __DIR__ . '/config/autoload.php'))
  ->register();