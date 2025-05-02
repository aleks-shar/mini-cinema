<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Controllers\Common;

use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\Seo\Actions\SeoCommon\EditAction;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

final class EditSeoCommonController extends Controller
{
    public function __invoke(int $seoId): Renderable|RedirectResponse
    {
        return view('seo::common.edit', [
            'seo' => (new EditAction())->handle($seoId),
        ]);
    }
}
