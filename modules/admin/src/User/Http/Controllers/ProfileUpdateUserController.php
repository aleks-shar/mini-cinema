<?php

declare(strict_types=1);

namespace App\Admin\User\Http\Controllers;

use App\Admin\Models\User;
use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\User\Http\Requests\UpdateUserRequest;
use Illuminate\Http\RedirectResponse;

final class ProfileUpdateUserController extends Controller
{
    public function __invoke(UpdateUserRequest $request, User $user): RedirectResponse
    {
        if (! $user->update(array_filter($request->validated()))) {
            return redirect()->route('admin.home')->withErrors(self::WRONG);
        }

        return redirect()->route(self::HOME)->with('success', 'Your profile has been successfully changed!');
    }
}
