<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Controllers\Common;

use App\Admin\Common\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;

final class CreateSeoCommonController extends Controller
{
    public function __invoke(): Renderable
    {
        return view('seo::common.create');
    }
}
