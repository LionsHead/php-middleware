<?php

namespace LionHead\Exception;

use \Exception;
use \LionHead\Container;

class UserException extends Exception implements ExceptionInterface
{
    public function __construct($message, $code = 0){
        $this->message = $message;
        $this->code = $code == 0 ? null : $code;
    }

    public function getUserMessage(Container $container)
    {
        return $container['view']->render('exception/error.twig', [
            'title' => $this->message,
            'code' => $this->code
        ]);
    }
}
