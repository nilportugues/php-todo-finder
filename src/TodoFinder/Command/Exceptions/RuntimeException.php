<?php

namespace NilPortugues\TodoFinder\Command\Exceptions;

class RuntimeException extends \RuntimeException
{
    public function __construct()
    {
        $message = "Malformatted YAML. Follow the YAML sample file structure";
        parent::__construct($message);
    }
}
