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
            $html .= '<h3>';
            $html .= " Code: ".$this->exception->getCode();
            $html .= " - ". $this->exception->getMessage();
            $html .= '</h3>';
            $html .= " File: ". $this->exception->getFile();
            $html .= ", line: <b>". $this->exception->getLine() ."</b>";
            $html .= '';
            $html .= "<h4> Trace </h4>";
            $html .= '<pre>';
            $html .=  $this->exception->getTraceAsString() . "\n";
            $html .= '</pre>';
            $html .= "<h4> Print full trace </h4>";
            $html .= '<pre>';
            $html .= $this->getFullTrace();
            $html .= '</pre>';
        } else {
            // обычный вариант
            $html = $this->exception->getMessage();
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
