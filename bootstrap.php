<?php

define('DEBAG_MODE', true);

define('LH_PATH', __DIR__ . DIRECTORY_SEPARATOR);

ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);

//  сессии
define('SESSION_LIFE_TIME', 1728000);
define('SESSION_SAVE_HANDLER', 'memcached'); // memcached, memcachem, files
// временная зона
date_default_timezone_set('Etc/GMT-3');

// путь к приложению
define('PATH_APP', LH_PATH . 'app/' );
// конфигурация
define('PATH_CONFIG', LH_PATH . 'config/');
// шаблоны
define('PATH_TEMPLATE', PATH_APP .  'template/' );
// кэш
define('PATH_CACHE', PATH_APP . 'cache/');
define('PATH_TEMPLATE_CACHE', PATH_CACHE .  'twig_cache/' );


// cdn
define('CDN_LINK', 'https://d2cdn-a.akamaihd.net');
define('CDN_VERSION', 'v=301115');

/**
 *  Composer autoload
 *  добавление новых:
 *  	$loader->add('NameSpace\\', 'path/NameSpace/');
 */
require_once LH_PATH . 'vendor/autoload.php';

$app = new LionHead\Kernel();

// http route
require LH_PATH . 'app/routes.php';

// StackPHP middleware builder
require LH_PATH . 'app/middleware.php';

$app->run();
