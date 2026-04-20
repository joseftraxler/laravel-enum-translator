<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        // PSR-12 baseline
        '@PSR12' => true,

        // Risky rules
        'strict_comparison' => true,
        'strict_param' => true,
        'no_alias_functions' => true,
        'no_alias_language_construct_call' => true,

        // Laravel style
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'no_unused_imports' => true,

        // Disable rewriting quotes
        'single_quote' => false,

        // Readability
        'no_trailing_whitespace' => true,
        'no_whitespace_in_blank_line' => true,
        'trim_array_spaces' => true,
        'whitespace_after_comma_in_array' => true,

        'concat_space' => ['spacing' => 'one'],

        // Modern PHP
        'modernize_types_casting' => true,
        'modernize_strpos' => true,
        'nullable_type_declaration_for_default_null_value' => true,

        // Force declare strict types
        'declare_strict_types' => true,
    ])
    // 💡 by default, Fixer looks for `*.php` files excluding `./vendor/` - here, you can groom this config
    ->setFinder(
        (new Finder())
            ->in([
                __DIR__ . '/src',
                __DIR__ . '/tests',
            ])
    )
    ;
