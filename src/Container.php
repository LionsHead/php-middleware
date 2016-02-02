<?php

namespace LionHead;

use \Pimple\Container as Pimple;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
/**
 *
 */
class Container extends Pimple
{

    /**
     * __construct description
     * @method __construct
     * @param  Kernel      $app [description]
     */
    public function __construct(Kernel $app)
    {
        parent::__construct();
        $this->setDefaultContainers($app);
    }

    /**
     * create containers
     *  - app       = instanceof \LionHead\Kernel
     *  - database  = instanceof db provider
     *  - auth      = instanceof user
     *  - view      = instanceof Twig
     * @method setDefaultContainers
     */
    private function setDefaultContainers($app)
    {
        // kernel application
        $this['app'] = $app;

        // response
        $this['response'] = new Response(null, 200);

        // database driver
        $this['database'] = function ($c) {
            return new \LionHead\DataBase\Mysql($c, require_once PATH_CONFIG.'/mysql.php');
        };

        // user driver
        $this->container['auth'] = function ($c) {
            return new \LionHead\Auth\User($c);
        };

        // twig template
        $this['view'] = function ($c) {
            return new \LionHead\View\Twig($c);
        };
    }
}
