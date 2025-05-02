<?php

declare(strict_types=1);

namespace App\Admin\Setting\Http\Controllers;

use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\Common\Models\HistorySetting;
use App\Admin\Common\Repositories\HistoryRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

final class HistoryIdSettingsController extends Controller
{
    public function __invoke(int $id, HistoryRepository $historyRepository): Renderable|RedirectResponse
    {
        $history = $historyRepository->getOneHistorySettings($id);

        if (! $history instanceof HistorySetting) {
            return redirect()->route('settings.show')->withErrors(['Параметр не был найден.']);
        }

        return view('setting::historyId', ['data' => $history]);
    }
}
