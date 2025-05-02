<?php

declare(strict_types=1);

use App\Admin\Auth\Http\Controllers\LogoutController;
use App\Admin\Common\Http\Controllers\Home\HomeController;
use App\Admin\Common\Http\Middleware\SeoRequestMiddleware;
use App\Admin\Seo\Http\Controllers\Common\CreateSeoCommonController;
use App\Admin\Seo\Http\Controllers\Common\DestroySeoCommonController;
use App\Admin\Seo\Http\Controllers\Common\EditSeoCommonController;
use App\Admin\Seo\Http\Controllers\Common\HistoryIdSeoCommonController;
use App\Admin\Seo\Http\Controllers\Common\HistorySeoCommonController;
use App\Admin\Seo\Http\Controllers\Common\ShowSeoCommonController;
use App\Admin\Seo\Http\Controllers\Common\StoreSeoCommonController;
use App\Admin\Seo\Http\Controllers\Common\UpdateSeoCommonController;
use App\Admin\Seo\Http\Controllers\DestroyDomainSeoController;
use App\Admin\Seo\Http\Controllers\DomainSeoCommonController;
use App\Admin\Seo\Http\Controllers\DomainSeoCommonPostController;
use App\Admin\Seo\Http\Controllers\EditDomainSeoController;
use App\Admin\Seo\Http\Controllers\HistoryDomainSeoController;
use App\Admin\Seo\Http\Controllers\HistoryIdDomainSeoController;
use App\Admin\Seo\Http\Controllers\IndexDomainSeoController;
use App\Admin\Seo\Http\Controllers\StoreDomainSeoController;
use App\Admin\Seo\Http\Controllers\TemplateStoreDomainSeoController;
use App\Admin\User\Http\Controllers\ProfileUpdateUserController;
use App\Admin\User\Http\Controllers\ProfileUserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:60,1', 'auth:admin', 'admin', SeoRequestMiddleware::class,
    ])->prefix('admin')->group(function () {
        Route::get('seo/individual/history', HistoryDomainSeoController::class)
            ->name('individual-history');

        Route::get('seo/individual/history/{id:int}', HistoryIdDomainSeoController::class)
            ->name('individual-history-id');

        Route::get('seo/individual/all', IndexDomainSeoController::class)->name('individual-all');

        Route::get('/seo/individual/{category:string}/{uri:string}/{idd:int}/edit', EditDomainSeoController::class)
            ->name('seo.individual.edit');

        Route::post('/seo/individual/{id:int}/{category:string}/individualStore', StoreDomainSeoController::class)
            ->name('seo.individual.store');

        Route::post('/seo/individual/{id:int}/{category:string}/templateStore', TemplateStoreDomainSeoController::class)
            ->name('seo.individual.template.store');

        Route::delete('/seo/individual/{id:int}/destroy', DestroyDomainSeoController::class)
            ->name('seo.individual.destroy');

        Route::get('/seo/individual/common', DomainSeoCommonController::class)
            ->name('seo.individual.common');

        Route::post('/seo/individual/common', DomainSeoCommonPostController::class)
            ->name('seo.individual.common.post');

        Route::post('/seo/individual/common/title', DomainSeoCommonController::class)
            ->name('seo.individual.common.title');

        Route::get('/home', HomeController::class)->name('admin.home');

        Route::get('/user/profile/{user}', ProfileUserController::class)->name('user.profile');

        Route::post('/user/profile/{user}', ProfileUpdateUserController::class)->name('user.profile_edit');

        Route::post('/logout', LogoutController::class)->name('logout');
    });
Route::middleware(['throttle:40,1', 'auth:admin', 'admin', SeoRequestMiddleware::class,
    ])->prefix('admin/seo/common')->group(function () {
        Route::get('/history/', HistorySeoCommonController::class)->name('seo.history.common');

        Route::get('/history/{id:int}', HistoryIdSeoCommonController::class)->name('seo.history.common.id');

        Route::get('/', ShowSeoCommonController::class)->name('seo.show');

        Route::get('/create', CreateSeoCommonController::class)->name('seo.create');

        Route::get('/{seoId:int}/edit', EditSeoCommonController::class)->name('seo.edit');

        Route::post('/store', StoreSeoCommonController::class)->name('seo.store');

        Route::post('/{seoId:int}/update', UpdateSeoCommonController::class)->name('seo.update');

        Route::delete('/{seoId:int}/destroy', DestroySeoCommonController::class)->name('seo.destroy');
    });
