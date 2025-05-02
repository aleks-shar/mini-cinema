<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Controllers;

use App\Admin\Seo\Services\DomainSeoService;
use App\Admin\Seo\Services\MetaTagService;
use Illuminate\Http\RedirectResponse;

final class TemplateStoreDomainSeoController extends DomainSeoBaseController
{
    public function __invoke(int $id, string $category): RedirectResponse
    {
        if (! (new DomainSeoService())->templateStore($id, $category)) {
            return redirect()->back()->withErrors([self::FAILED]);
        }

        return redirect()->route('individual-all')->with('tags', (new MetaTagService())->getAll());
    }
}
