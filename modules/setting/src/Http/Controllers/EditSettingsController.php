<?php

declare(strict_types=1);

namespace App\Admin\Setting\Http\Controllers;

use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\Setting\Models\DomainSettings;
use App\Admin\Setting\Services\SettingsService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

final class EditSettingsController extends Controller
{
    public function __invoke(int $settings_id, SettingsService $settingsService): Renderable|RedirectResponse
    {
        $setting = $settingsService->findSettings($settings_id);

        if (! $setting instanceof DomainSettings) {
            return redirect()->route('settings.show')->withErrors(['Параметр не был найден.']);
        }

        return view('setting::edit', ['settings' => $setting]);
    }
}
