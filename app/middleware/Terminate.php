<?php

namespace App\Middleware;

use \LionHead\Http\KernelInterface;
use \LionHead\Http\TerminableInterface;
use \LionHead\Http\Request;
use \LionHead\Http\Response;

class Terminate implements TerminableInterface
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
        $this->closure = function ($size) {
                $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];
                $re = ($size > 0) ? round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) :  0;
                return $re . ' ' . $unit[$i];
            };
    }

    public function bar(callable $convert)
    {
        echo '<div class="container">
            <p>  <span class="label label-'. ( (defined('DEBAG_MODE') && DEBAG_MODE == true) ? 'danger"> Development:' : 'success"> Production:' ) .' <span> </p>
            <p> Microtime: <b>' . ( microtime(true) - LH_START_TIME ) . '</b> </p>
            <p> Memory: ' . $convert(LH_START_MEMORY) . ' =>  ' . $convert(memory_get_usage()) . ', Peak: ' . $convert(memory_get_peak_usage()) . ' </p>
        </div>';
    }

    public function terminate(Request $request, Response $response)
    {
        if (defined('DEBAG_MODE') && DEBAG_MODE == true) {
            $callable = $this->closure;
            $this->bar($callable);
        }
    }
}
