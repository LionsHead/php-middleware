<?php

define('APP_START_TIME', microtime(true));
define('APP_START_MEMORY', memory_get_usage());

define('APP_PUBLIC', $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR);
// Основной домен без http\www и т.д.
define('HOME_URL', 'localhost');


require '../bootstrap.php';
