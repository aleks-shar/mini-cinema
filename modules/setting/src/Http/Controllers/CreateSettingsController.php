<?php

declare(strict_types=1);

namespace App\Admin\Setting\Http\Controllers;

use App\Admin\Common\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;

final class CreateSettingsController extends Controller
{
    public function __invoke(): Renderable
    {
        return view('setting::create');
    }
}
