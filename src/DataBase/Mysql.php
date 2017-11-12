<?php

namespace LionHead\DataBase;

use \PDO;
use \PDOException;
use \LionHead\Container;
/**
 *
 */
class Mysql
{
    private $pdo_instance;
    private $container = null;

    /**
     * __construct
     * @method __construct
     * @param  LionHead\Container $container [description]
     * @param  array            $db        [description]
     */
    function __construct(Container $container, array $db = [])
    {
        $this->container = $container;

        // pdo connect options
        $options  = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => TRUE,
        ];
        try {
            $this->pdo_instance = new PDO($db['host'], $db['user'], $db['password'], $options);
        } catch (PDOException $e) {
            echo 'Connect failed: ' . $e->getMessage();
        }
    }

    /**
     * call pdo method
     * @method __call
     * @param  string $method
     * @param  array $args
     * @return pdo method
     */
    public function __call($method, $args)
    {
        return call_user_func_array([
            $this->pdo_instance,
            $method
        ], $args);
    }

    /**
     * send sql request
     * @method request
     * @param  string  $sql request
     * @param  array  $args params
     * @return mixed       response
     */
    public function request($sql, array $args = [])
    {
        $r = $this->pdo_instance->prepare($sql);
        $r->execute($args);
        return $r;
    }

    /**
     * [__destruct description]
     * @method __destruct
     */
    function __destruct(){
        $this->pdo_instance = null;
    }
}
