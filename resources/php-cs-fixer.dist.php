<?php

declare(strict_types=1);

/**
 * PHP CS Fixer（コンテナ内では resources が /var/www/html にマウントされる）
 *
 * 対象ディレクトリ・ルールはこのファイルで管理する。
 */
$targetDir = sprintf('%s/htdocs', __DIR__);

$finder = PhpCsFixer\Finder::create();
$finder
    ->in($targetDir)
    ->name('*.php')
    ->exclude(['vendor', 'node_modules']);

$config = new PhpCsFixer\Config();
$config->setRiskyAllowed(true);
$config->setUsingCache(false);
$config->setRules([
    '@PSR12'                 => true,
    'binary_operator_spaces' => [
        'default'   => 'single_space',
        'operators' => [
            '=>' => 'align_single_space_minimal',
            '='  => 'align_single_space_minimal',
        ],
    ],
]);
$config->setFinder($finder);

return $config;
