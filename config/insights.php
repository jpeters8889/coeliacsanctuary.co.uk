<?php

declare(strict_types=1);

use ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenTraits;
use ObjectCalisthenics\Sniffs\Metrics\MaxNestingLevelSniff;
use NunoMaduro\PhpInsights\Domain\Sniffs\ForbiddenSetterSniff;
use ObjectCalisthenics\Sniffs\NamingConventions\ElementNameMinimalLengthSniff;
use ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff;
use NunoMaduro\PhpInsights\Domain\Metrics\Architecture\Classes;
use ObjectCalisthenics\Sniffs\Metrics\MethodPerClassLimitSniff;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use SlevomatCodingStandard\Sniffs\Commenting\EmptyCommentSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ReturnTypeHintSniff;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenFinalClasses;
use ObjectCalisthenics\Sniffs\Metrics\PropertyPerClassLimitSniff;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenNormalClasses;
use SlevomatCodingStandard\Sniffs\TypeHints\PropertyTypeHintSniff;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenPrivateMethods;
use ObjectCalisthenics\Sniffs\Classes\ForbiddenPublicPropertySniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ParameterTypeHintSniff;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenDefineFunctions;
use SlevomatCodingStandard\Sniffs\Commenting\DocCommentSpacingSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\DeclareStrictTypesSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Arrays\ArrayIndentSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\TypeHintDeclarationSniff;
use NunoMaduro\PhpInsights\Domain\Insights\CyclomaticComplexityIsHigh;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowEmptySniff;
use SlevomatCodingStandard\Sniffs\TypeHints\DisallowMixedTypeHintSniff;
use SlevomatCodingStandard\Sniffs\Classes\SuperfluousExceptionNamingSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterNotSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\AlphabeticallySortedUsesSniff;
use SlevomatCodingStandard\Sniffs\Classes\SuperfluousAbstractClassNamingSniff;
use SlevomatCodingStandard\Sniffs\Commenting\InlineDocCommentDeclarationSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\AssignmentInConditionSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\UnusedUsesSniff as UnusedUsesSniffAlias;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowShortTernaryOperatorSniff;

return [
    /*
    |--------------------------------------------------------------------------
    | Default Preset
    |--------------------------------------------------------------------------
    |
    | This option controls the default preset that will be used by PHP Insights
    | to make your code reliable, simple, and clean. However, you can always
    | adjust the `Metrics` and `Insights` below in this configuration file.
    |
    | Supported: "default", "laravel", "symfony"
    |
    */

    'preset' => 'laravel',

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may adjust all the various `Insights` that will be used by PHP
    | Insights. You can either add, remove or configure `Insights`. Keep in
    | mind that all added `Insights` must belong to a specific `Metric`.
    |
    */

    'add' => [
        Classes::class => [
            ForbiddenFinalClasses::class,
        ],
    ],

    'remove' => [
        AlphabeticallySortedUsesSniff::class,
        DeclareStrictTypesSniff::class,
        DisallowMixedTypeHintSniff::class,
        ForbiddenDefineFunctions::class,
        ForbiddenNormalClasses::class,
        ForbiddenTraits::class,
        TypeHintDeclarationSniff::class,
        InlineDocCommentDeclarationSniff::class,
        ArrayIndentSniff::class,
        EmptyCommentSniff::class,
        SpaceAfterNotSniff::class,
        UnusedUsesSniffAlias::class,
        DocCommentSpacingSniff::class,
        LineLengthSniff::class,
        ForbiddenPublicPropertySniff::class,
        NoSetterSniff::class,
        ForbiddenSetterSniff::class,
        DisallowShortTernaryOperatorSniff::class,
        SuperfluousExceptionNamingSniff::class,
        AssignmentInConditionSniff::class,
        DisallowEmptySniff::class,
        ParameterTypeHintSniff::class,
        PropertyTypeHintSniff::class,
        ReturnTypeHintSniff::class,
        DisallowEmptySniff::class,
        SuperfluousAbstractClassNamingSniff::class,
        NoEmptyCommentFixer::class,
        ElementNameMinimalLengthSniff::class,
    ],

    'config' => [
        ForbiddenPrivateMethods::class => [
            'title' => 'The usage of private methods is not idiomatic in Laravel.',
        ],
        CyclomaticComplexityIsHigh::class => [
            'maxComplexity' => 15,
        ],
        FunctionLengthSniff::class => [
            'maxLength' => 40,
        ],
        MethodPerClassLimitSniff::class => [
            'maxCount' => 15,
        ],
        PropertyPerClassLimitSniff::class => [
            'maxCount' => 15,
        ],
        MaxNestingLevelSniff::class => [
            'maxNestingLevel' => 3,
        ],
    ],

    'exclude' => [
        'imports',
        'architect',
    ],
];
