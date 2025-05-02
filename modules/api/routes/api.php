<?php

declare(strict_types=1);

use App\Api\Http\Controllers\Movie\MovieIndexController;
use App\Api\Http\Controllers\Movie\MovieShowController;
use App\Api\Http\Controllers\Series\SeriesIndexController;
use App\Api\Http\Controllers\Series\SeriesShowController;
use Illuminate\Support\Facades\Route;

Route::get('/movies', MovieIndexController::class)->name('api.movies.index');
Route::get('/series', SeriesIndexController::class)->name('api.series.index');
Route::get('/movies/{movie}', MovieShowController::class)->name('api.movies.show');
Route::get('/series/{series}', SeriesShowController::class)->name('api.series.show');
