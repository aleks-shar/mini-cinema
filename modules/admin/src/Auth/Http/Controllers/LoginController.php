<?php

declare(strict_types=1);

namespace App\Admin\Auth\Http\Controllers;

use App\Admin\Auth\Http\Data\LoginData;
use App\Admin\Models\User;
use App\Api\Http\Controllers\Controller;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class LoginController extends Controller
{
    public function __invoke(Request $request, LoginData $loginData, AuthManager $manager): RedirectResponse
    {
        /** @var StatefulGuard $guard */
        $guard = $manager->guard('admin');
        $array = ['email' => $loginData->email, 'password' => $loginData->password];

        if ($guard->attempt($array)) {
            /** @var User $user */
            $user = $guard->user();

            if ($user->is_active === 0) {
                $guard->logout();

                return redirect()->back()->withErrors('Your account is not activated.');
            }

            $users = User::query()->where(['role' => 'admin', 'single_mode' => 1])->get();

            if ($users instanceof Collection && $users->count() > 0) {
                $guard->logout();

                return redirect()->back()->withErrors('Single mode is enabled. Access only admin users.');
            }

            $request->session()->regenerate();

            if ($user->role !== 'admin' && $user->role !== 'seo') {
                $guard->logout();

                return redirect()->back()->withErrors('The provided credentials do not match our records.');
            }

            return redirect()->route('admin.home');
        }

        return redirect()->back()->withErrors(['The provided credentials do not match our records.']);
    }
}
