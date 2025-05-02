<?php

declare(strict_types=1);

namespace App\Admin\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use RedisException;

final class AdminServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->mergeConfigFrom(__DIR__ . '/../../config/admin.php', 'admin');
    }

    /**
     * @throws RedisException
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . './../../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . './../../routes/admin.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'admin');
        Paginator::defaultView('admin::vendor.pagination.bootstrap-5');
    }
}
