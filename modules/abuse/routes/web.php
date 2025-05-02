<?php

declare(strict_types=1);

use App\Admin\Abuse\Http\Controllers\AbuseCommonController;
use App\Admin\Abuse\Http\Controllers\AbuseController;
use App\Admin\Abuse\Http\Controllers\AllAbusesController;
use App\Admin\Abuse\Http\Controllers\HistoryAbuseController;
use App\Admin\Abuse\Http\Controllers\UnAbuseController;
use App\Admin\Common\Http\Middleware\SeoRequestMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:30,1', 'auth:admin', 'admin', SeoRequestMiddleware::class,
    ])->prefix('admin')->group(function () {
        Route::delete('/abuse/{id:int}/{category:string}', AbuseController::class)
            ->name('abuse.abuse');

        Route::get('/abuse/{id:int}/{category:string}', UnAbuseController::class)
            ->name('abuse.un-abuse');

        Route::get('/abuse/all', AllAbusesController::class)->name('abuse.all');

        Route::get('/abuse/history', HistoryAbuseController::class)->name('abuse.history');

        Route::get('/abuse/common', AbuseCommonController::class)
            ->name('abuse.common');

        Route::post('/abuse/common/title', AbuseCommonController::class)
            ->name('abuse.common.title');
    });
