<?php

namespace NilPortugues\TodoFinder\Command\Exceptions;

/**
 * Class ConfigFileException
 * @package NilPortugues\ForbiddenFunctions\Command
 */
class ConfigFileException extends \InvalidArgumentException
{
    public function __construct($configFile)
    {
        $message = sprintf('Provided configuration file %s does not exist', $configFile);
        parent::__construct($message);
    }
}
