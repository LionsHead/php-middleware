<?php
namespace Lionhead;

use \Exception;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
/**
 *
 */

class App
{
    // instanceof LionHead\Container
    private $container = null;

    /**
     * __construct
     * @method __construct()
     * @param  LionHead\Container $container description
     */
    public function __construct($container) {
        $this->container = $container;
    }

    /**
     * возвращает di - контейнер
     * @param $name string
     * @return object di container|
     */
    public function get($name = null)
    {
        return (is_null($name)) ? $this->container : $this->container[$name];
    }

    /**
     * response description
     * @method response
     * @param  [type]   $content [description]
     * @param  integer  $code    [description]
     * @param  [type]   $headers [description]
     * @return [type]            [description]
     */
    public function response($content, $code = 200, array $headers = [])
    {
        # code...
    }

}
