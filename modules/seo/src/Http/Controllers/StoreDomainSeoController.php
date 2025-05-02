<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Controllers;

use App\Admin\Seo\Http\Requests\Seo\UpdateIndividualSeoRequest;
use App\Admin\Seo\Services\DomainSeoService;
use Illuminate\Http\RedirectResponse;

final class StoreDomainSeoController extends DomainSeoBaseController
{
    public function __invoke(UpdateIndividualSeoRequest $request, int $id, string $category): RedirectResponse
    {
        if (! (new DomainSeoService())->individualStore($id, $category, $request->validated())) {
            return redirect()->back()->withErrors([self::FAILED]);
        }

        return redirect()->back()->with('success', 'OK');
    }
}
