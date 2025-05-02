<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Controllers;

use App\Admin\Seo\Models\MetaTag;
use App\Admin\Seo\Services\DomainSeoService;
use Illuminate\Http\RedirectResponse;

final class DestroyDomainSeoController extends DomainSeoBaseController
{
    public function __invoke(int $id): RedirectResponse
    {
        $tag = MetaTag::query()->find($id);

        if (! $tag instanceof MetaTag) {
            return $this->redirectBackWithError(self::FAILED);
        }

        $result = (new DomainSeoService())->destroyMetaTag($tag);

        if (! $result) {
            return redirect()->back()->withErrors([self::FAILED]);
        }

        return redirect()->route('individual-all');
    }
}
