<?php

return PhpCsFixer\Config::create()
    ->setUsingCache(false)
    ->setRules([
        '@PSR2' => true,
        'braces' => ['allow_single_line_closure' => true, 'position_after_anonymous_constructs' => 'same', 'position_after_control_structures' => 'same', 'position_after_functions_and_oop_constructs' => 'same'],
        'declare_equal_normalize' => ['space' => 'single'],
        'hash_to_slash_comment' => true,
        'native_function_casing' => true,
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_extra_consecutive_blank_lines' => true,
        'no_multiline_whitespace_before_semicolons' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_whitespace_in_blank_line' => true,
        'standardize_not_equals' => true,
        'line_ending' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
        ->exclude('templates_c', 'vendor')
        ->in(__DIR__.'/Website/AtariLegend/php')
    );

/*
This document has been generated with
https://mlocati.github.io/php-cs-fixer-configurator/
you can change this configuration by importing this YAML code:

fixerSets:
  - '@PSR2'
fixers:
  braces:
    allow_single_line_closure: true
    position_after_anonymous_constructs: same
    position_after_control_structures: same
    position_after_functions_and_oop_constructs: same
  declare_equal_normalize:
    space: single
  hash_to_slash_comment: true
  native_function_casing: true
  standardize_not_equals: true

*/
