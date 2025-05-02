<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Controllers\Common;

use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\Common\Repositories\HistoryRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

final class HistoryIdSeoCommonController extends Controller
{
    public function __invoke(int $id): Renderable|RedirectResponse
    {
        return view('seo::common.historyId', ['data' => (new HistoryRepository())->getHistoryCommonForId($id)]);
    }
}
