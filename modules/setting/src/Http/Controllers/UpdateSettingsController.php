<?php

declare(strict_types=1);

namespace App\Admin\Setting\Http\Controllers;

use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\Common\Services\HistoryService;
use App\Admin\Setting\Http\Requests\UpdateDomainSettingsRequest;
use App\Admin\Setting\Models\DomainSettings;
use App\Admin\Setting\Services\SettingsService;
use Illuminate\Http\RedirectResponse;

final class UpdateSettingsController extends Controller
{
    public function __invoke(
        UpdateDomainSettingsRequest $request,
        int $seo_id,
        SettingsService $settingsService,
        HistoryService $saveHistoryService,
    ): RedirectResponse {
        $setting = $settingsService->findSettings($seo_id);

        if (! $setting instanceof DomainSettings) {
            return redirect()->route('settings.show')->withErrors(['Параметр не был найден.']);
        }

        $old = clone $setting;

        $new = $settingsService->update($request->validated(), $setting);

        if (! $new instanceof DomainSettings) {
            return redirect()->route('settings.show')->withErrors(['Параметр не был обновлен.']);
        }

        $saveHistoryService->saveForUpdateDomainSettings($old, $new);

        return redirect()->route('settings.show')->with('success', 'Параметр успешно изменен.');
    }
}
