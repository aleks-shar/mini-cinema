<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Controllers;

use App\Admin\Common\Models\HistoryIndividualTag;
use App\Admin\Common\Services\HistoryService;
use App\Admin\Seo\Http\Requests\Seo\HistoryDomainSeoRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

final class HistoryDomainSeoController extends DomainSeoBaseController
{
    /**
     * @throws BindingResolutionException
     */
    public function __invoke(HistoryDomainSeoRequest $request, HistoryService $service): Renderable|RedirectResponse
    {
        /** @var array<string, mixed> $validated */
        $validated = $request->validated();
        $validated['daterange'] = $this->getDateRange('year');

        return view('seo::history.history', [
            'tags' => $service->getPaginateHistoryIndividualTag($validated),
            'type' => $validated['type'] ?? null,
            'title' => $validated['title'] ?? null,
            'action' => $validated['action'] ?? null,
            'emails' => HistoryIndividualTag::query()->select(['email'])->distinct(['email'])->get(),
            'daterange' => $validated['daterange'],
        ]);
    }
}
