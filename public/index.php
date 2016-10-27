<?php

define('APP_START_TIME', microtime(true));
define('APP_START_MEMORY', memory_get_usage());
define('APP_PUBLIC', $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR);

require '../bootstrap.php';
