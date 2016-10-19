<?php

define('APP_START_TIME', microtime(true));
define('APP_START_MEMORY', memory_get_usage());

define('DS', DIRECTORY_SEPARATOR);
define('APP_PUBLIC', $_SERVER['DOCUMENT_ROOT'] . DS);
// Основной домен без http\www и т.д.
define('HOME_URL', 'localhost');


require '../bootstrap.php';
