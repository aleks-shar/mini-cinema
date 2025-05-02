<?php

declare(strict_types=1);

namespace App\Admin\Setting\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

final class SettingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . './../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'setting');
        Paginator::defaultView('admin::vendor.pagination.bootstrap-5');
    }
}
