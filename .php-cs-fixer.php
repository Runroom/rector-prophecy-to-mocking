<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$finder = Finder::create()
    ->in(__DIR__);

$config = new Config();

$config->setParallelConfig(ParallelConfigFactory::detect());
$config->setRules([
    '@Symfony' => true,
    '@Symfony:risky' => true,
    'array_syntax' => ['syntax' => 'short'],
    'class_attributes_separation' => true,
    'combine_consecutive_issets' => true,
    'combine_consecutive_unsets' => true,
    'concat_space' => ['spacing' => 'one'],
    'header_comment' => ['header' => "\n"],
    // @todo: Enable this
    // 'declare_strict_types' => true,
    'no_extra_blank_lines' => true,
    'no_php4_constructor' => true,
    'no_useless_else' => true,
    'no_useless_return' => true,
    'ordered_class_elements' => true,
    'ordered_imports' => true,
    'phpdoc_align' => ['align' => 'left'],
    'phpdoc_order' => true,
    'compact_nullable_type_declaration' => true,
    'void_return' => false,
     'strict_comparison' => true,
     'strict_param' => true,
    // @todo: Make this one below `true`
    'yoda_style' => false,
    'php_unit_strict' => true,
    'php_unit_test_annotation' => ['style' => 'annotation'],
])
->setRiskyAllowed(true)
->setFinder($finder);

return $config;
