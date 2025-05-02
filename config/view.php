<?php

declare(strict_types=1);

return [
    'paths' => [
        base_path() . '/modules/admin/resources/views',
    ],
    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),
];
