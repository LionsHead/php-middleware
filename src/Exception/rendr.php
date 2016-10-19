<?php

namespace LionHead\Exception;

use \Exception;
use \LionHead\Container;

class HtmlTemplate
{
    private $container = null;
    private $exception = null;

    /**
     * __construct
     * @method __construct()
     * @param  LionHead\Container $container description
     */
    public function __construct(Container $container, $exception) {
        $this->container = $container;
        $this->exception = $exception;
    }

    /**
     * [ExceptionError description]
     * @method ExceptionError
     * @param  [type]         $e [description]
     */
    public function renderException()
    {
        $html = '<div class="row"> Details: <br>';
        if (defined('DEBUG_MODE') && DEBUG_MODE == true)
        {
            // при включенном режиме отладки
            $html .= '<pre>';
            $html .= " Message: ". $this->exception->getMessage()." \n";
            $html .= " Code: ".$this->exception->getCode()." \n";
            $html .= " File: ". $this->exception->getFile() ." \n";
            $html .= " Line: ". $this->exception->getLine() ." \n";
            $html .= '</pre>';
            $html .= " Trace \n";
            $html .= '<pre>';
            $html .=  $this->exception->getTraceAsString() . "\n";
            $html .= '</pre>';
            $html .= " Print full trace \n";
            $html .= '<pre>';
            $html .= $this->getFullTrace();
            $html .= '</pre>';
        } else {
            // обычный вариант
            $html = $this->exception->getMessage();
        }
        $html .= '</div>';

        echo $this->renderTemplate($html);
    }

    private function getFullTrace()
    {
        ob_start();
        print_r($this->exception->getTrace());
        $trace = ob_get_contents();
        ob_end_clean();

        return $trace;
    }

    private function renderTemplate($html)
    {
        return '<!DOCTYPE html>
        <html lang="ru">
        '.$this->getHeadContent().'
          <body>
        <div class="container">
          <div class="Exception">
          <div class="TitleException"> <b>Ошибка выполнения сценария:</b> </div>
          ' . $html . '
          </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
          </body>
        </html>';
    }

    private function getHeadContent()
    {
        return '<head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width. initial-scale=1">
          <title> Application error </title>

          <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
          <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->

          <style>'. $this->getExceptionStyle() .'</style>
        </head>';
    }

    private function getExceptionStyle()
    {
        return '
        body {
            min-width: 950px;
            font-family: "Helvetica Neue".Helvetica.Arial.sans-serif; font-size: 14px;
            line-height: 1.42857143;
            color: #333;
            background-color: #fff;
            margin: 0;
        }
        pre {
            display: block;
            padding: 5px; margin-top: 10px;
            color: #333;
            word-break: break-all; word-wrap: break-word;
            background-color: #f5f5f5;
            border: 1px solid #ccc; border-radius: 4px;
        }
        .TitleException {
            position: relative;
            min-height: 40px;
            margin-bottom: 5px;
            font-size: 24px;
            padding: 5px;
        }
        .Exception {
            width: 950px;
            max-width: none !important;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }
        ';
    }
}
