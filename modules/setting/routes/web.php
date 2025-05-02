<?php

declare(strict_types=1);

use App\Admin\Common\Http\Middleware\SeoRequestMiddleware;
use App\Admin\Setting\Http\Controllers\CreateSettingsController;
use App\Admin\Setting\Http\Controllers\DestroySettingsController;
use App\Admin\Setting\Http\Controllers\EditSettingsController;
use App\Admin\Setting\Http\Controllers\HistoryIdSettingsController;
use App\Admin\Setting\Http\Controllers\HistorySettingsController;
use App\Admin\Setting\Http\Controllers\ShowSettingsController;
use App\Admin\Setting\Http\Controllers\StoreSettingsController;
use App\Admin\Setting\Http\Controllers\UpdateSettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:40,1', 'auth:admin', 'admin', SeoRequestMiddleware::class,
    ])->prefix('admin/domain/settings')->group(function () {
        Route::get('/', ShowSettingsController::class)->name('settings.show');

        Route::get('/history', HistorySettingsController::class)->name('settings.history');

        Route::get('/history/{id:int}', HistoryIdSettingsController::class)
            ->name('settings.history.show');

        Route::get('/{settings_id:int}/edit', EditSettingsController::class)->name('settings.edit');

        Route::post('/{settings_id:int}/update', UpdateSettingsController::class)
            ->name('settings.update');

        Route::get('/create', CreateSettingsController::class)->name('settings.create');

        Route::post('/store', StoreSettingsController::class)->name('settings.store');

        Route::delete('/{settings_id:int}/delete', DestroySettingsController::class)
            ->name('settings.destroy');
    });
