<?php

namespace App\Middleware;

use \LionHead\Auth\Session;
/**
 *
 */
class Auth
{

    function __construct($app)
    {
        return new Session($app);
    }
}
