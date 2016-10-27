<?php

define('DEBUG_MODE', true);

define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR);

ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);

//  сессии
define('SESSION_LIFE_TIME', 1728000);
// временная зона
date_default_timezone_set('Etc/GMT-3');

// путь к приложению
define('PATH_APP', ROOT_PATH . 'app/' );
// конфигурация
define('PATH_CONFIG', ROOT_PATH . 'config/');
// шаблоны
define('PATH_TEMPLATE', PATH_APP .  'template/' );
// кэш
define('PATH_CACHE', ROOT_PATH . 'cache/');
define('PATH_TEMPLATE_CACHE', PATH_CACHE .  'twig_cache/' );
// cdn
define('CDN_LINK', 'https://d2cdn-a.akamaihd.net');
define('CDN_VERSION', 'v=301115');

// Основной домен без http\www и т.д.
define('HOME_URL', 'localhost');

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
