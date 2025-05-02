<?php

declare(strict_types=1);

namespace App\Admin\Setting\Http\Controllers;

use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\Setting\Services\SettingsService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

final class ShowSettingsController extends Controller
{
    public function __invoke(SettingsService $settingsService): Renderable|RedirectResponse
    {
        return view('setting::show', ['data' => $settingsService->getDomainSettings()]);
    }
}
