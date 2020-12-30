<?php

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setFinder(PhpCsFixer\Finder::create()
        ->exclude('tests')
        ->in(__DIR__))
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_empty_comment' => false,
        'ordered_imports' => ['sort_algorithm' => 'length'],
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'yoda_style' => false,
        'declare_strict_types' => true,
        'no_superfluous_phpdoc_tags' => false,
    ]);
