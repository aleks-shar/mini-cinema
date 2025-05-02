<?php

declare(strict_types=1);

namespace App\Admin\Common\Http\Controllers\Home;

use App\Admin\Common\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

final class HomeController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        return redirect()->route('settings.show');
    }
}
