<?php

declare(strict_types=1);

namespace Coeliac\Base\CsFixer;

use PhpCsFixer\Config as BaseConfig;
use PhpCsFixer\ConfigInterface;

class Config extends BaseConfig
{
    public const RULE_DEFINITIONS = [
        '@coeliac' => [
            '@PSR12' => true,
            'array_syntax' => ['syntax' => 'short'],
            'binary_operator_spaces' => true,
            'blank_line_before_statement' => [
                'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try'],
            ],
            'class_attributes_separation' => [
                'elements' => [
                    'method' => 'one',
                ],
            ],
            'declare_strict_types' => true,
            'heredoc_indentation' => ['indentation' => 'same_as_start'],
            'indentation_type' => true,
            'method_argument_space' => [
                'on_multiline' => 'ensure_fully_multiline',
                'keep_multiple_spaces_after_comma' => true,
            ],
            'method_chaining_indentation' => true,
            'no_superfluous_phpdoc_tags' => false,
            'no_unused_imports' => true,
            'not_operator_with_successor_space' => true,
            'ordered_imports' => ['sort_algorithm' => 'alpha'],
            'phpdoc_scalar' => true,
            'phpdoc_single_line_var_spacing' => true,
            'phpdoc_trim_consecutive_blank_line_separation' => true,
            'phpdoc_var_without_name' => true,
            'single_trait_insert_per_statement' => true,
            'single_quote' => true,
            'trailing_comma_in_multiline' => true,
            'unary_operator_spaces' => true,
        ],
        '@coeliac:risky' => [
            // ...
        ],
    ];

    public function __construct()
    {
        parent::__construct('Coeliac');
    }

    public static function make(): self
    {
        return new self();
    }

    public function setRules(array $rules): ConfigInterface
    {
        foreach (array_keys(self::RULE_DEFINITIONS) as $key) {
            if (($rules[$key] ?? false)) {
                unset($rules[$key]);
                $rules = array_merge(self::RULE_DEFINITIONS[$key], $rules);
            }
        }

        return parent::setRules($rules);
    }
}
