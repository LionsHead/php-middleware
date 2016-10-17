<?php

define('LH_START_TIME', microtime(true));
define('LH_START_MEMORY', memory_get_usage());

define('DS', DIRECTORY_SEPARATOR);
define('LH_PUBLIC', $_SERVER['DOCUMENT_ROOT'] . DS);
// Основной домен без http\www и т.д.
define('HOME_URL', 'localhost');


require '../bootstrap.php';
