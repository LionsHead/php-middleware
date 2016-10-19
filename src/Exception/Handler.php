<?php

namespace LionHead\Exception;

use \Exception;
use \LionHead\Container;

class Handler
{
    private $container = null;

    /**
     * __construct
     * @method __construct()
     * @param  LionHead\Container $container description
     */
    public function __construct(Container $container) {
        $this->container = $container;

        $this->registerHandler();
    }

    /**
     * register Handler
     * @method registerHandler
     * @return [type]          [description]
     */
    public function registerHandler()
    {
        set_exception_handler(function ($e) {
            ( new Handler($this->container) )->getException($e);
        });

        // обработчик ошибок
        set_error_handler(function () {
            ( new Handler($this->container) )->getError(func_get_args());
        });
    }

    /**
     * Стандартный обработчик исключений
     * @method getException
     * @param  Exception    $e [description]
     * @return Информация об исключении
     */
    public function getException($e)
    {
        if (in_array('LionHead\Exception\ExceptionInterface', class_implements($e))) {
            $this->userExceptionError($e);
        }
        else {
            $this->standartExceptionError($e);
        }

    }

    /**
     * getError description
     * @method getError
     * @param  array    $args $errno, $str, $file, $line
     * @return Информация об ошибке
     */
    public function getError(array $args)
    {
        list($errno, $str, $file, $line, $errcontext) = $args;
        $exit = false;
        if (defined('DEBUG_MODE') && DEBUG_MODE == true){
            switch ($errno) {
                case E_USER_ERROR:
                    echo "<b>Fatal Error!</b> [{$errno}] {$str}<br />\n";
                    echo " Ошибка в файле {$file}; строка {$line} ";
                    echo "<br />\n";
                    $exit = true;
                break;
                case E_USER_WARNING:
                    echo "<b>WARNING!</b> [{$errno}] {$str}<br />\n";
                    echo " Ошибка в файле {$file}; строка {$line} ";
                    echo "<br />\n";
                case E_WARNING:
                    $type = 'Warning';
                    echo "<b>WARNING!</b> [{$errno}] {$str}<br />\n";
                    echo " Ошибка в файле {$file}; строка {$line} ";
                    echo "<br />\n";
                break;
                case E_USER_NOTICE:
                    echo "<b>NOTICE!</b> [{$errno}] {$str}<br />\n";
                    echo " Ошибка в файле {$file}; строка {$line} ";
                    echo "<br />\n";
                case E_NOTICE:
                    echo "<b>NOTICE!</b> [{$errno}] {$str}<br />\n";
                    echo " Ошибка в файле {$file}; строка {$line} ";
                    echo "<br />\n";
                default:
                    // Unknown Error
                    $exit = true;

                    echo "Неизвестная ошибка: [{$errno}] {$str}<br />\n";
                    echo " Ошибка в файле {$file}; строка {$line} ";
                    echo "<br />\n";
                break;

            }
        } else {
            # TODO log?
        }
        // exit?

        /* Не запускаем внутренний обработчик ошибок PHP */
        return true;
    }

    /**
     * [ExceptionError description]
     * @method ExceptionError
     * @param  [type]         $e [description]
     */
    private function standartExceptionError($e){
        // ( new HtmlTemplate($this->container, $e) )->renderException();

        echo ( new StandartException($e) )->getUserMessage($this->container);

//         echo '<!DOCTYPE html>
// <html lang="ru">
// <head>
//     <title> '. $e->getMessage() .' </title>
// <style>
// pre {
//     display: block;
//     padding: 5px; margin-top: 10px;
//     color: #333;
//     word-break: break-all; word-wrap: break-word;
//     background-color: #f5f5f5;
//     border: 1px solid #ccc; border-radius: 4px;
// }
// body {
//     min-width: 950px;
//     font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; font-size: 14px;
//     line-height: 1.42857143;
//     color: #333;
//     background-color: #fff;
//     margin: 0;
// }
// .TitleException {
//     position: relative;
//     min-height: 40px;
//     margin-bottom: 5px;
//     font-size: 24px;
//     padding: 5px;
// }
// .Exception {
//     width: 950px;
//     max-width: none !important;
//     padding-right: 15px;
//     padding-left: 15px;
//     margin-right: auto;
//     margin-left: auto;
// }
//         </style>
//         </head>
//         <body>
// <div class="Exception">
// <div class="TitleException"> <b>Ошибка выполнения сценария:</b> </div>
// <a href="/">На главную</a> ';
//         if (defined('DEBUG_MODE') && DEBUG_MODE == true){
//             // при включенном режиме отладки
//             echo '<br> Details: <br>';
//             echo '<pre>';
//             echo " Message: ", $e->getMessage()." \n";
//             echo " Code: ".$e->getCode()." \n";
//             echo " File: ", $e->getFile() ," \n";
//             echo " Line: ", $e->getLine() ," \n";
//             echo '</pre>';
//             echo " Trace \n";
//             echo '<pre>';
//             echo  $e->getTraceAsString() , "\n";
//             echo '</pre>';
//             echo " Full Trace \n";
//             echo '<pre>';
//             print_r($e->getTrace());
//             echo '</pre>';
//         } else {
//             // обычный вариант
//             echo '<b> Details:</b> '.$e->getMessage();
//         }
//         echo '</div> </body></html>';
    }

    /**
     * [UserExceptionError description]
     * @method UserExceptionError
     * @param  ExceptionInterface $e [description]
     */
    public function userExceptionError(ExceptionInterface $e)
    {
         echo $e->getUserMessage($this->container);
    }
}
