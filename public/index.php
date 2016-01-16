<?php

define('LH_START_TIME', microtime(true));
define('LH_START_MEMORY', memory_get_usage());

define('DS', DIRECTORY_SEPARATOR);
define('LH_PUBLIC', $_SERVER['DOCUMENT_ROOT'] . DS);
// Основной домен без http\www и т.д.
define('HOME_URL', 'localhost');

/**
 * https only
 */

  if ((!isset($_SERVER['HTTPS']) or $_SERVER['HTTPS'] == "") and $_SERVER['HTTP_HOST'] !== 'localhost') {
  //header('HTTP/1.1 301 Moved Permanently');
  //header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
  }



require ('../bootstrap.php');
