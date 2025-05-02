<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Controllers\Common;

use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\Seo\Actions\SeoCommon\DestroyAction;
use Illuminate\Http\RedirectResponse;

final class DestroySeoCommonController extends Controller
{
    public function __invoke(int $seoId): RedirectResponse
    {
        $seo = (new DestroyAction())->handle($seoId);

        if (! $seo) {
            return redirect()->back()->withErrors(self::FAILED);
        }

        return redirect()->route('seo.show')->with('success', 'Тэг успешно удален');
    }
}
