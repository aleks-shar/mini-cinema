<?php

declare(strict_types=1);

namespace App\Api\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

final class RouteServiceProvider extends ServiceProvider
{
    public const string HOME = '/';

    public function boot(): void
    {
        $this->routes(function () {
            Route::prefix('api')
                ->group(__DIR__ . './../../routes/api.php');
        });
    }
}
