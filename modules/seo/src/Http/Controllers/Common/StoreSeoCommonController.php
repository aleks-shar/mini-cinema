<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Controllers\Common;

use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\Seo\Actions\SeoCommon\StoreAction;
use App\Admin\Seo\Http\Requests\SeoCommon\StoreSeoRequest;
use App\Api\Models\Seo;
use Illuminate\Http\RedirectResponse;

final class StoreSeoCommonController extends Controller
{
    public function __invoke(StoreSeoRequest $request): RedirectResponse
    {
        $seo = (new StoreAction())->handle($request->validated());

        if (! $seo instanceof Seo) {
            return redirect()->back()->withErrors(self::FAILED);
        }

        return redirect()->route('seo.show')->with('success', 'Тэг успешно создан');
    }
}
