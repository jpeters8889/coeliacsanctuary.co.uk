<?php

declare(strict_types=1);

use PhpCsFixer\Finder;

require __DIR__.'/vendor/autoload.php';

$finder = Finder::create()->in([
    __DIR__.'/App',
    __DIR__.'/config',
    __DIR__.'/tests',
])->notName('php-cs-fixer.dist.php');

return \Coeliac\Base\CsFixer\Config::make()
    ->setFinder($finder)
    ->setRules([
        '@coeliac' => true,
        '@coeliac:risky' => true,
    ])
    ->setRiskyAllowed(true);
