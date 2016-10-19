<?php

define('DEBUG_MODE', true);

define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR);

ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);

//  сессии
define('SESSION_LIFE_TIME', 1728000);
// временная зона
date_default_timezone_set('Etc/GMT-3');




// cdn
define('CDN_LINK', 'https://d2cdn-a.akamaihd.net');
define('CDN_VERSION', 'v=301115');

/**
 *  Composer autoload
 *  добавление новых:
 *  	$loader->add('NameSpace\\', 'path/NameSpace/');
 */
require_once ROOT_PATH . 'vendor/autoload.php';

$app = new LionHead\Kernel();

// http route
require PATH_CONFIG . 'routes.php';

// StackPHP middleware builder
require PATH_CONFIG . 'middleware.php';

$app->run();
