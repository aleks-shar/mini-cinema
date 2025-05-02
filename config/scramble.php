<?php

declare(strict_types=1);

use Dedoc\Scramble\Http\Middleware\RestrictedDocsAccess;

return [
    'api_path' => 'api',
    'api_domain' => null,
    'theme' => 'light',
    'info' => [
        'version' => env('API_VERSION', '0.0.1'),
        'description' => 'Cinema API',
    ],
    'ui' => [
        'hide_try_it' => false,
        'try_it_credentials_policy' => 'include',
    ],
    'middleware' => [
        'web',
        RestrictedDocsAccess::class,
    ],
    'extensions' => [],
];
