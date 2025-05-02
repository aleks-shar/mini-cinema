<?php

declare(strict_types=1);

use App\Admin\Auth\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:10,1', 'admin'])->prefix('admin')->group(function () {
    Route::get('/login', function () {
        return view('admin::auth.login');
    });

    Route::post('/login', LoginController::class)->name('login');
});
