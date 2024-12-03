<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector;

return RectorConfig::configure()
    ->withPreparedSets(
        true,
        true,
        true,
        true,
        true,
        true,
        true,
        true,
        true,
    )
    ->withPhpSets(
        php83: true,
    )
    ->withPaths([
        __DIR__ . '/src',
    ])
    ->withSkip([
        RenameForeachValueVariableToMatchMethodCallReturnTypeRector::class => [
            __DIR__ . '/src/Form/View/Helper/FormGroupsCollection.php',
            __DIR__ . '/src/Form/View/Helper/FormGroupsCollectionTemplate.php',
        ],
    ]);
