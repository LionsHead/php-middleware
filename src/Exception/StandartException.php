<?php

namespace LionHead\Exception;

use \Exception;
use \LionHead\Container;

class StandartException extends Exception implements ExceptionInterface
{
    private $exception = null;

    public function __construct($exception){
        $this->exception = $exception;
    }

    public function getUserMessage(Container $container)
    {
        return $container['view']->render('exception/exception.twig', [
            'title' => $this->exception->getMessage(),
            'code' => $this->exception->getCode(),
            'message' => $this->getDetailsMessage()
        ]);
    }

    private function getDetailsMessage()
    {
        $html = '';
        if (defined('DEBUG_MODE') && DEBUG_MODE == true)
        {
            // при включенном режиме отладки
            $convert = function ($size) {
                $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];
                $re = ($size > 0) ? round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) :  0;
                return $re . ' ' . $unit[$i];
            };

            $html .= '<h3>';
            $html .= ' Code: '.$this->exception->getCode();
            $html .= ' - '. $this->exception->getMessage();
            $html .= ' <span class="label label-danger">DEBAG MODE </span>';
            $html .= '</h3>';
            $html .= '<div class="file-name">';
            $html .= ' File: '. $this->exception->getFile();
            $html .= ', line: <b>'. $this->exception->getLine() .'</b>';
            $html .= '</div>';
            $html .= '<div class="row">
              <div class="col-xs-2"> ENV: <b>'. getenv('APP_ENV') .'</b> </div>
               <div class="col-xs-6"> Memory - start: ' . $convert(APP_START_MEMORY) . ', total: ' . $convert(memory_get_usage()) . ', Peak: ' . $convert(memory_get_peak_usage()) . ' </div>
            </div>';
            $html .= '<h4>Trace: </h4> <pre>' . $this->exception->getTraceAsString() . '</pre>';
            $html .= '<h4><a href="#" data-toggle="collapse" data-target="#collapseFullTrace" aria-expanded="false" aria-controls="collapseExample">
              Full Trace
            </a>
            </h4>';
            $html .= '<div class="collapse" id="collapseFullTrace">
            <pre>' . $this->getFullTrace() . '</pre>
            </div>';
        } else {
            // обычный вариант
            $html .= '<h3>';
            $html .= $this->exception->getMessage();
            $html .= '</h3>';
        }

        return $html;
    }

    private function getFullTrace()
    {
        ob_start();
        print_r($this->exception->getTrace());
        $trace = ob_get_contents();
        ob_end_clean();

        return $trace;
    }
}
