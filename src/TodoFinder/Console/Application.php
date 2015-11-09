<?php


namespace NilPortugues\TodoFinder\Console;

use NilPortugues\TodoFinder\Command\FinderCommand;

class Application extends \Symfony\Component\Console\Application
{
    /**
     * Returns the long version of the application.
     *
     * @return string The long application version
     */
    public function getLongVersion()
    {
        $name = <<<NAME

<info> PHP To-Do Finder</info>                                   <comment>by Nil Portugués</comment>
====================================================================
NAME;

        return sprintf($name);
    }

    /**
     * Initializes all the composer commands
     *
     * @return \Symfony\Component\Console\Command\Command[]
     */
    protected function getDefaultCommands()
    {
        $commands = parent::getDefaultCommands();
        $commands[] = new FinderCommand();

        return $commands;
    }
}
