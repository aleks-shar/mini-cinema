<?php

declare(strict_types=1);

namespace App\Admin\Auth\Http\Controllers;

use App\Api\Http\Controllers\Controller;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class LogoutController extends Controller
{
    public function __invoke(Request $request, AuthManager $manager): RedirectResponse
    {
        $manager->logout();
        $request->session()->flush();
        DB::query()->from('sessions')->whereNull('user_id')->delete();

        return redirect()->route('login');
    }
}
