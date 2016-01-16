<?php

namespace LionHead\Exception;

use \Exception;
use \LionHead\Container;

class NotFoundException extends Exception implements ExceptionInterface
{
    public function __construct($message, $code){
        $this->message = $message;
        $this->code = $code == 0 ? null : $code;
    }

    public function getUserMessage(Container $container)
    {
        return $container['view']->render('exception/not_found.twig', [
            'title' => $this->message,
            'code' => $this->code
        ]);
    }
}
