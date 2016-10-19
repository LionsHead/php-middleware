<?php

namespace LionHead;

use \LionHead\Container;
use \Closure;
use \FastRoute\RouteCollector;
use \FastRoute\Dispatcher;
use function \FastRoute\simpleDispatcher as Dispatcher;
use \LionHead\Exception\NotFoundException;
use \LionHead\Exception\Handler;
use \LionHead\Http\KernelInterface;
use \LionHead\Http\TerminableInterface;
use \LionHead\Http\Request;
use \LionHead\Http\Response;
use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \Dotenv\Dotenv as Environment;


/**
 * Основной класс
 */
class Kernel implements KernelInterface
{
    // Routes
    private $routes = [];
    // instance of \FastRoute\Dispatcher
    private $dispatcher = null;
    // instance of \Pimple\Container
    private $container = null;
    // inctance of \SplStac - middleware stack
    private $specs = null;
    // middleware instance
    private $stack = [];
    // settings
    private $configs = [];

    /**
     *  Create new application
     * @method __construct
     */
    function __construct()
    {
        $env = new Environment(ROOT_PATH);
        $env->load();
        if (empty(getenv('APP_ENV'))) putenv('APP_ENV=development');

        $this->configs = require_once PATH_CONFIG . 'environment/' . getenv('APP_ENV') . '.php';

        // di container
        $this->container = new Container($this);
        // exception handler
        new Handler($this->get());
        // middleware stack
        $this->specs = new \SplStack();
    }

    public function env()
    {
        return getenv('APP_ENV');
    }

    public function config($name = '') {
        return isset($this->configs[$name]) ? $this->configs[$name] : null;
    }

    /**
     * Adds an element to beginning of list middleware
     * @method unshift
     * @return object Kernel
     */
    public function unshift(/*$kernelClass, $args...*/)
    {
        if (func_num_args() === 0) {
            throw new \InvalidArgumentException("Missing argument(s) when calling unshift");
        }

        $this->specs->unshift( func_get_args() );

        return $this;
    }

    /**
     * Add middleware at the end of list
     * @method push
     * @return object Kernel
     */
    public function push(/*$kernelClass, $args...*/)
    {
        if (func_num_args() === 0) {
            throw new \InvalidArgumentException("Missing argument(s) when calling push");
        }

        $this->specs->push( func_get_args() );

        return $this;
    }

    /**
     * [resolve description]
     * @method resolve
     * @return [type]  [description]
     */
    public function resolve()
    {
        $app = $this;
        $middleware = [$app];

        foreach ($this->specs as $args) {
            $firstArg = array_shift($args);

            if (is_callable($firstArg)) {
                $app = $firstArg($app);
            } else {
                $kernelClass = $firstArg;
                array_unshift($args, $app);

                if (!class_exists($kernelClass)){
                    throw new \RuntimeException("Runtime error - class_exists {$kernelClass}");
                }

                $app = ( new \ReflectionClass($kernelClass) )->newInstanceArgs($args);
            }
            array_unshift($middleware, $app);
            $app = $this;
        }

        $this->stack = $middleware;
    }

    /**
     * handle description
     * @method handle
     * @param  Request $request [description]
     * @param  integer $type    [description]
     * @param  [type]  $catch   [description]
     * @return [type]           [description]
     */
    public function handle(Request $request, $type = 1, $catch = true)
    {
        $response = call_user_func($this, $request, $type, $catch);

        if (!$response instanceof Response) {
            throw new \RuntimeException('Kernel response error - object non type Response');
        }

        return $response;
    }

    /**
     * [terminate description]
     * @method terminate
     * @param  Request   $request  [description]
     * @param  Response  $response [description]
     * @return [type]              [description]
     */
    public function terminate(Request $request, Response $response)
    {
        $prevKernel = null;

        foreach ($this->stack as $kernel) {
            // if prev kernel was terminable we can assume this middleware has already been called
            if (!$prevKernel instanceof TerminableInterface && $kernel instanceof TerminableInterface) {
                $kernel->terminate($request, $response);
            }
            $prevKernel = $kernel;
        }
    }

    /**
     * [handle description]
     * @method handle
     * @param  Request $request [description]
     * @param  [type]  $type    [description]
     * @param  [type]  $catch   [description]
     * @return [type]           [description]
     */
    public function __invoke(Request $request, $type = 1, $catch = true)
    {
        $dispatcher = $this->createDispatcher();

        return $this->routeHandler( $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $request->getRequestUri()) );
    }

    /**
     * return di container
     * @param $name string
     * @return object di container
     */
    public function get($name = null)
    {
        return (is_null($name)) ? $this->container : $this->container[$name];
    }

    /**
     * getUri description
     * @method getUri
     * @return string request uri
     */
    public function getUri()
    {
        return '/'.trim(rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), '/');
    }

    /**
     * create new path
     * @method addRoute
     * @param  string $method  request method  ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS']
     * @param  sring $uri request uri pattern    /request/path/
     * @param  callable $handler route handler
     */
    public function addRoute($method, $uri, callable $handler)
    {
        $name = strtoupper($method) .'_'. $uri;
        $this->routes[$name] = [
            'method' => $method,
            'uri' => '/' . trim($uri, '/'),
            'handler' => $handler
        ];
    }

    /**
     * return route Dispatcher
     * @method createDispatcher
     * @return object Dispatcher
     */
    public function createDispatcher()
    {
        if (is_null($this->dispatcher)) {
            $this->dispatcher = Dispatcher(function(RouteCollector $r) {
                foreach ($this->routes as $route) {
                    $r->addRoute($route['method'], $route['uri'], $route['handler']);
                }
            });
        }

        return $this->dispatcher;
    }

    /**
     * [setHttpResponse description]
     * @method setHttpResponse
     * @param  array           $routeInfo route info array [ 0 - callable, 1 - arguments]
     */
    public function setHttpResponse(array $routeInfo)
    {
        $response = $routeInfo[1]($routeInfo[2],$this->get());

        // return instance of Response
        if (!$response instanceof Response) {
           $response = $this->get('response')->setContent($response);
        }
        return $response;
    }

    /**
     * [routeInfo description]
     * @method routeInfo
     * @param  array    $routeInfo [description]
     * @return [type]               [description]
     */
    public function routeHandler(array $routeInfo)
    {
        switch ($routeInfo[0]) {
            case Dispatcher::METHOD_NOT_ALLOWED:
                // 405 Method Not Allowed
                $allowedMethods = $routeInfo[1];

                throw new NotFoundException("Method Not Allowed", 405);
            break;
            case Dispatcher::FOUND:
                // вызов $handler с аргументами запроса
                if (is_callable($routeInfo[1]) && ($routeInfo[1] instanceof Closure)) {
                    /**
                     * имеется функция указанная в списке роутеров
                     * принимает в себя аргументы и инстанс $app
                     */
                    return $this->setHttpResponse($routeInfo);
                } else {
                    throw new NotFoundException("Not Acceptable", 406);
                }
            break;
            default:
                if ($this->env() == 'production') {
                    // 404 Not Found
                    throw new NotFoundException("Page not found", 404);
                } else {
                    // TODO: NoRouteError
                    throw new NotFoundException("Page not found", 404);
                }
            break;
        }
    }

    /**
     * Send http response
     * @method send
     * @param  Response $response  [description]
     * @param  [type]   $terminate [description]
     * @return [type]              [description]
     */
    public function send(Response $response, $terminate = true)
    {
        $response->sendHeaders();
        $response->sendContent();

        // terminate response
        if ($terminate == true){
            if (function_exists('fastcgi_finish_request')) {
                fastcgi_finish_request();
            } elseif ('cli' !== PHP_SAPI) {
                $targetLevel = 0;
                $flush = true;
                $status = ob_get_status(true);
                $level = count($status);
                // PHP_OUTPUT_HANDLER_* are not defined on HHVM 3.3
                $flags = defined('PHP_OUTPUT_HANDLER_REMOVABLE') ? PHP_OUTPUT_HANDLER_REMOVABLE | ($flush ? PHP_OUTPUT_HANDLER_FLUSHABLE : PHP_OUTPUT_HANDLER_CLEANABLE) : -1;

                while ($level-- > $targetLevel && ($s = $status[$level]) && (!isset($s['del']) ? !isset($s['flags']) || $flags === ($s['flags'] & $flags) : $s['del'])) {
                    if ($flush) {
                        ob_end_flush();
                    } else {
                        ob_end_clean();
                    }
                }
            }
        }
    }

    /**
     * [run description]
     * @method run
     * @param  string request path
     */
    public function run($request = null){
        $this->resolve();

        $request = $request ?: Request::createFromGlobals();
        $response = $this->handle($request);
        $this->send($response, false);

        $this->terminate($request, $response);
    }

    /**
     * use terminate?
     * @method __destruct
     */
    public function __destruct()
    {
        # code...
    }
}
