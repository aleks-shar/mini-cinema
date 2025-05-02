<?php

declare(strict_types=1);

namespace App\Admin\Setting\Http\Controllers;

use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\Common\Services\HistoryService;
use App\Admin\Setting\Models\DomainSettings;
use App\Admin\Setting\Services\SettingsService;
use Illuminate\Http\RedirectResponse;

final class DestroySettingsController extends Controller
{
    public function __invoke(
        int $settings_id,
        SettingsService $settingsService,
        HistoryService $saveHistoryService
    ): RedirectResponse {

        $setting = $settingsService->findSettings($settings_id);

        if (! $setting instanceof DomainSettings) {
            return redirect()->route('settings.show')->withErrors(['Параметр не был удален.']);
        }

        $old = clone $setting;

        if (! $settingsService->destroy($setting)) {
            return redirect()->route('settings.show')->withErrors(['Параметр не был удален.']);
        }

        $saveHistoryService->saveForDeleteDomainSettings($old);

        return redirect()->route('settings.show')->with('success', 'Параметр успешно удален.');
    }
}
