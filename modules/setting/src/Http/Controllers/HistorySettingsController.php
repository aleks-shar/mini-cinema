<?php

declare(strict_types=1);

namespace App\Admin\Setting\Http\Controllers;

use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\Common\Repositories\HistoryRepository;
use App\Admin\Setting\Http\Data\HistoryData;
use App\Admin\Setting\Services\SettingsService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class HistorySettingsController extends Controller
{
    /**
     * @throws BindingResolutionException
     */
    public function __invoke(
        Request $request,
        HistoryData $historyData,
        SettingsService $settingsService,
        HistoryRepository $historyRepository,
    ): Renderable|RedirectResponse {
        $historyData->daterange = $historyData->daterange ?? $this->getDateRange('year');

        return view('setting::history', [
            'data' => $historyRepository->getHistorySettingsList($historyData),
            'action' => $request->query('action'),
            'emails' => $settingsService->getEmailsForHistory()->get(),
            'daterange' => $historyData->daterange,
        ]);
    }
}
