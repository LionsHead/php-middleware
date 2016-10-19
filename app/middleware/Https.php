<?php

namespace App\Middleware;

/**
 * https only
 */
class Https
{

    function __construct($app)
    {
        if ((!isset($_SERVER['HTTPS']) or $_SERVER['HTTPS'] == '') and $_SERVER['HTTP_HOST'] !== 'localhost') {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            exit;
        }
    }
}
