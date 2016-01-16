<?php

namespace LionHead;

use \Pimple\Container as Pimple;
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
        $this['app'] = $app;

        $this['database'] = function ($c) {
            return new \LionHead\DataBase\Mysql($c, require_once PATH_CONFIG.'/mysql.php');
        };

        $this->container['auth'] = function ($c) {
            return new \LionHead\Auth\User($c);
        };

        $this['view'] = function ($c) {
            return new \LionHead\View\Twig($c);
        };
    }
}
