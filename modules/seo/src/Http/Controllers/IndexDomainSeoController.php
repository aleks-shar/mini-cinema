<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Controllers;

use App\Admin\Seo\Http\Requests\Seo\AllDomainSeoRequest;
use App\Admin\Seo\Models\MetaTag;
use App\Admin\Seo\Services\MetaTagService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

final class IndexDomainSeoController extends DomainSeoBaseController
{
    /**
     * @throws BindingResolutionException
     */
    public function __invoke(AllDomainSeoRequest $request): Renderable|RedirectResponse
    {
        /** @var array<array-key, mixed> $validated */
        $validated = $request->validated();

        if (empty($validated)) {
            $validated['daterange'] = $this->getDateRange('year');
        }

        return view('seo::index-individual', [
            'tags' => (new MetaTagService())->getAllForFilter($validated),
            'type' => $validated['type'] ?? null,
            'title' => $validated['title'] ?? null,
            'action' => $validated['action'] ?? null,
            'emails' => MetaTag::query()->select(['email'])->distinct(['email'])->get(),
            'daterange' => $validated['daterange'],
        ]);
    }
}
