<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'asset_url' => env('ASSET_URL'),
    'timezone' => env('TIMEZONE', 'UTC'),
    'locale' => 'en',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
    'providers' => ServiceProvider::defaultProviders()->merge([
        App\Admin\Providers\AdminServiceProvider::class,
        App\Admin\Common\Providers\CommonServiceProvider::class,
        App\Admin\Setting\Providers\SettingServiceProvider::class,
        \App\Admin\Abuse\Providers\AbuseServiceProvider::class,
        App\Admin\Seo\Providers\SeoServiceProvider::class,
        App\Api\Providers\AppServiceProvider::class,
        App\Api\Providers\AuthServiceProvider::class,
        App\Api\Providers\EventServiceProvider::class,
        App\Api\Providers\RouteServiceProvider::class,
    ])->toArray(),
    'aliases' => Facade::defaultAliases()->merge([
    ])->toArray(),
];
