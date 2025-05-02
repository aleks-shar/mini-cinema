<?php

declare(strict_types=1);

namespace App\Admin\Setting\Http\Controllers;

use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\Common\Services\HistoryService;
use App\Admin\Setting\Http\Requests\StoreDomainSettingsRequest;
use App\Admin\Setting\Models\DomainSettings;
use App\Admin\Setting\Services\SettingsService;
use Illuminate\Http\RedirectResponse;

final class StoreSettingsController extends Controller
{
    public function __invoke(
        StoreDomainSettingsRequest $request,
        SettingsService $settingsService,
        HistoryService $saveHistoryService,
    ): RedirectResponse {

        $setting = $settingsService->create($request->validated());

        if (! $setting instanceof DomainSettings) {
            return redirect()->route('settings.show')->withErrors(['Параметр не был создан.']);
        }

        $saveHistoryService->saveForCreateDomainSettings($setting);

        return redirect()->route('settings.show')->with('success', 'Параметр успешно создан.');
    }
}
