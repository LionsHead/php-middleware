<?php

namespace LionHead\Exception;

interface ExceptionInterface
{
    // public function __construct($message, $code);
    public function getUserMessage(\LionHead\Container $container);
}
