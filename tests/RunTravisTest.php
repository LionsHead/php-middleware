<?php

use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;

/**
 * надеюсь это никто не увидит
 */
class RunTravisTest extends \PHPUnit_Framework_TestCase
{
    public $arrayRoutes = [
        ['GET', '/', 'get request'],
        ['POST', '/', 'post request'],
        ['PUT', '/', 'put request'],
        ['PATCH', '/', 'path request'],
        ['DELETE', '/', 'del request'],
        ['GET', '/path', 'get App\Home\path'],
        ['GET', '/path/to', 'path to'],
        ['GET', '/path/value/{id}', 'path to ']

    ];

    public $arrayBadRequest = [
        ['GET', '/', '/get_request'],
        ['POST', '/', '/post_request'],
        ['PUT', '/', '/put_request'],
        ['PATCH', '/', '/path_request'],
        ['DELETE', '/', '/del_request'],
        ['GET', '/path', '/get/App/Home/path'],
        ['GET', '/path/to', '/path'],
        ['GET', '/path/value/{id}', '/path/value/123/404']

    ];

     /**
     * @dataProvider additionProvider
     */
    public function testRunDifferentPHPVersions($method, $path,  $response)
    {
        $_SERVER['REQUEST_METHOD'] = $method;


        $app = new \LionHead\Kernel();

        $this->assertInstanceOf('LionHead\Kernel', $app); #
        $this->assertInstanceOf('LionHead\Container', $app->get()); #

        foreach ($this->arrayRoutes as $value) {
            $app->addRoute($value[0], $value[1], function ($arg, $di) use ($value) {
                return $value[2];
            });
        }

        $this->assertEquals($response, $app->handle( Request::create($path, $method) )); #

    }

    public function testException()
    {
        $this->setExpectedException(
          '\LionHead\Exception\NotFoundException', 'Right Message', 322
        );
        throw new \LionHead\Exception\NotFoundException('The Right Message', 322);
    }

     /**
     * @dataProvider additionErrorPath
     */
    public function testExceptionHas404error($method, $path, $request)
    {
        $_SERVER['REQUEST_METHOD'] = $method;

        $app = new \LionHead\Kernel();

        $this->assertInstanceOf('LionHead\Kernel', $app); #
        $this->assertInstanceOf('LionHead\Container', $app->get()); #

        foreach ($this->arrayBadRequest as $value) {
            $app->addRoute($value[0], $path, function ($arg, $di) {
                return 'request';
            });
        }

        /* assert */
        $this->setExpectedException(
          '\LionHead\Exception\NotFoundException', 'Page not found', 404
        );

        $app->handle( Request::create($request, $method) );
    }

     /**
     * @dataProvider additionMethods
     */
    public function testExceptionHas405($method)
    {
        $_SERVER['REQUEST_METHOD'] = $method;

        $app = new \LionHead\Kernel();

        $this->assertInstanceOf('LionHead\Kernel', $app); #
        $this->assertInstanceOf('LionHead\Container', $app->get()); #

         $app->addRoute('GET', '/', function ($arg, $di) { return 1; });

        /* assert */
        $this->setExpectedException(
          '\LionHead\Exception\NotFoundException', 'Method Not Allowed', '405'
        );

        $app->handle( Request::create('/', $method) );
    }


    public function additionProvider()
    {
        return $this->arrayRoutes;
    }

    public function additionErrorPath()
    {
        return $this->arrayBadRequest;
    }

    public function additionMethods()
    {
        return [
            ['POST'],
            ['PUT'],
            ['PATCH'],
            ['DELETE'],
            ['OPTIONS'],
            ['CHETO']
            ];
    }

}
