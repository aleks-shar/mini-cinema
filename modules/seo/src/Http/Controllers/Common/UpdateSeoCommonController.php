<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Controllers\Common;

use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\Seo\Actions\SeoCommon\UpdateAction;
use App\Admin\Seo\Http\Requests\SeoCommon\UpdateSeoRequest;
use App\Api\Models\Seo;
use Illuminate\Http\RedirectResponse;

final class UpdateSeoCommonController extends Controller
{
    public function __invoke(UpdateSeoRequest $request, int $seoId): RedirectResponse
    {
        $seo = (new UpdateAction())->handle($request->validated(), $seoId);

        if (! $seo instanceof Seo) {
            return redirect()->back()->withErrors(self::FAILED);
        }

        return redirect()->route('seo.show')->with('success', 'Тэг успешно изменен');
    }
}
