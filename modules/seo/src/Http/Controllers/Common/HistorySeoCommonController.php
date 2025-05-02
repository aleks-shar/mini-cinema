<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Controllers\Common;

use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\Common\Models\HistoryCommonTag;
use App\Admin\Common\Repositories\HistoryRepository;
use App\Admin\Seo\Http\Requests\SeoCommon\HistorySeoCommonRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

final class HistorySeoCommonController extends Controller
{
    /**
     * @throws BindingResolutionException
     */
    public function __invoke(HistorySeoCommonRequest $request): Renderable|RedirectResponse
    {
        /** @var array<array-key, mixed> $validated */
        $validated = $request->validated();

        if (empty($validated)) {
            $validated['daterange'] = $this->getDateRange('year');
        }

        return view('seo::common.history', [
            'data' => (new HistoryRepository())->getPaginateHistoryCommon($validated),
            'aliases' => HistoryCommonTag::query()->select(['alias'])->distinct('alias')->get(),
            'emails' => HistoryCommonTag::query()->select(['email'])->distinct(['email'])->get(),
            'daterange' => $validated['daterange'],
        ]);
    }
}
