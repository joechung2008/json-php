<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude([
        'api-laravel/bootstrap',
        'api-laravel/public',
        'api-laravel/storage',
        'api-laravel/vendor',
        'api-symfony/var',
        'api-symfony/vendor',
    ]);

return (new Config())
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        // Add more rules as needed
    ]);
