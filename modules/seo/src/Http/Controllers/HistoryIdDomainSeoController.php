<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Controllers;

use App\Admin\Common\Services\HistoryService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

final class HistoryIdDomainSeoController extends DomainSeoBaseController
{
    public function __invoke(int $id, HistoryService $service): Renderable|RedirectResponse
    {
        return view('seo::history.historyId', ['data' => $service->getHistoryIndividualTagForId(id: $id)]);
    }
}
