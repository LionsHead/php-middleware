<?php

namespace LionHead;

use \Pimple\Container as Pimple;
use \LionHead\Http\Request;
use \LionHead\Http\Response;
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
        $this->createDefaultContainers($app);
    }

    /**
     * create containers
     *  - app       = instanceof \LionHead\Kernel
     *  - database  = instanceof db provider
     *  - auth      = instanceof user
     *  - view      = instanceof Twig
     * @method createDefaultContainers
     */
    private function createDefaultContainers($app)
    {
        // kernel application
        $this['app'] = $app;

        // environment
        $this['db_params'] = require_once PATH_CONFIG . 'environment/'.$app->env().'.php';

        // response
        $this['response'] = new Response(null, 200);

        // database driver
        $this['database'] = function ($c) {
            return new \LionHead\DataBase\Mysql($c, $this['db_params']);
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
