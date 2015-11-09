<?php
$composer1 = __DIR__.'/../vendor/autoload.php';
$composer2 = __DIR__.'/../../../autoload.php';

$autoload1 = \file_exists($composer1) ? include $composer1 : \false;
$autoload2 = \file_exists($composer2) ? include $composer2 : \false;

if ($autoload1 === \false && $autoload2 === \false) {
    echo 'You must set up the project dependencies, run the following commands:'.\PHP_EOL.
        'curl -sS https://getcomposer.org/installer | php'.\PHP_EOL.
        'php composer.phar install'.\PHP_EOL;

    return;
}
