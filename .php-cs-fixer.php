<?php

declare(strict_types=1);

$header = <<<EOM
(c) 2025 rc design visual concepts (rc-design.at)
_________________________________________________
The TYPO3 project - inspiring people to share!
_________________________________________________
EOM;

$config = \TYPO3\CodingStandards\CsFixerConfig::create();
$config
    ->setHeader($header, true)
    ->addRules([
        '@PER:risky' => true,
        '@PHP80Migration:risky' => true,
        ## Migriert das PHP zur Version 8.2
        '@PHP83Migration' => true,
        ## schreibt das declare(strict_types=1); bei jedem PHP Dokument dazu
        'declare_strict_types' => true,
        'fully_qualified_strict_types' => true,
        ## Fixt die Einrückung in allen PHP Dokumenten
        'array_indentation' => true,
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => false,
            'import_functions' => false,
        ],
        'no_unneeded_import_alias' => true,
        'ordered_imports' => [
            'imports_order' => ['class', 'function', 'const'],
            'sort_algorithm' => 'alpha',
        ],
        'phpdoc_align' => true,
        'phpdoc_annotation_without_dot' => true,
        'phpdoc_indent' => true,
        'phpdoc_inline_tag_normalizer' => true,
        'phpdoc_line_span' => true,
        'phpdoc_no_useless_inheritdoc' => true,
        'phpdoc_order' => true,
        'phpdoc_order_by_value' => true,
        'phpdoc_separation' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_summary' => true,
        'phpdoc_tag_casing' => true,
        'phpdoc_tag_type' => true,
        'phpdoc_to_comment' => [
            'ignored_tags' => [
                'phpstan-ignore-line',
                'phpstan-ignore-next-line',
                'todo',
            ],
        ],
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_last',
            'sort_algorithm' => 'alpha',
        ],
        'phpdoc_var_annotation_correct_order' => true,
        'phpdoc_var_without_name' => true,
        'self_accessor' => true,
    ])
    ->getFinder()
    ->exclude('templates')
    ->exclude('tests/Unit/Fixtures')
    ->in(__DIR__ . '/src/packages/')
    ->append(['typo3-coding-standards']);

return $config;
