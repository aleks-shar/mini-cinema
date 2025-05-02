<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Controllers\Common;

use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\Seo\Actions\SeoCommon\ShowAction;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

final class ShowSeoCommonController extends Controller
{
    public function __invoke(): Renderable|RedirectResponse
    {
        return view('seo::common.show', [
            'data' => (new ShowAction())->handle(),
        ]);
    }
}
