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
        $label = defined('DEBUG_MODE') && DEBUG_MODE == true ? 'danger'  : 'success';
        $debug = defined('DEBUG_MODE') && DEBUG_MODE == true ? 'true'  : 'false';
        echo '<div class="footer">
          <div class="col-xs-2"> <span class="label label-'. $label .'">DEBAG MODE: '. $debug .'</span> </div>
          <div class="col-xs-2"> ENV: '. getenv('APP_ENV') .' </div>
          <div class="col-xs-4"> Microtime: <b>' . ( microtime(true) - APP_START_TIME ) . '</b> </div>
          <div class="col-xs-4"> <span class="label label-info">Memory</span> start: ' . $convert(APP_START_MEMORY) . ', total: ' . $convert(memory_get_usage()) . ', Peak: ' . $convert(memory_get_peak_usage()) . ' </div>
          <p> Time: '.date(DATE_RFC822).'</p>
        </div>';

        error_log('microtime '. ( microtime(true) - APP_START_TIME ));
    }

    public function terminate(Request $request, Response $response)
    {
        if (defined('DEBUG_MODE') && DEBUG_MODE == true) {
            $callable = $this->closure;
            $this->bar($callable);
        }
    }
}
