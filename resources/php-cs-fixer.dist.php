<?php

declare(strict_types=1);

/**
 * PHP CS Fixer（コンテナ内では resources が /var/www/html にマウントされる）
 *
 * 対象ディレクトリ・ルールはこのファイルで管理する。
 */
$targetDir = sprintf('%s/htdocs', __DIR__);

$finder = new PhpCsFixer\Finder()
    ->in([$targetDir])
    ->name('*.php')
    ->exclude(['vendor', 'node_modules']);

return new PhpCsFixer\Config()
    ->setRiskyAllowed(true)
    ->setUsingCache(false)
    ->setRules([
        '@PSR12' => true,
        'binary_operator_spaces' => [
            'default' => 'single_space',
            'operators' => [
                '=>' => 'align_single_space_minimal',
                '=' => 'align_single_space_minimal',
            ],
        ],
    ])
    ->setFinder($finder);
