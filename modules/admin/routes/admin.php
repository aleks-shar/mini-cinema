<?php

declare(strict_types=1);

use App\Admin\Common\Http\Middleware\AdminRequestMiddleware;
use App\Admin\User\Http\Controllers\DeleteAllSessionsUserController;
use App\Admin\User\Http\Controllers\DeleteOneSessionsUserController;
use App\Admin\User\Http\Controllers\SessionsUserController;
use App\Admin\User\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:60,1', 'auth:admin', 'admin', AdminRequestMiddleware::class,
    ])->prefix('admin')->group(function () {
        Route::get('/user/sessions', SessionsUserController::class)->name('admin.user.sessions');

        Route::delete('/user/sessions/destroy/all', DeleteAllSessionsUserController::class)->name('admin.user.sessions.destroy.all');

        Route::delete('/user/sessions/{id}', DeleteOneSessionsUserController::class)->name('admin.user.sessions.destroy');

        Route::delete('/user/block/{id}', [UserController::class, 'block'])->name('admin.user.block');

        Route::resource('/user', UserController::class);
    });
