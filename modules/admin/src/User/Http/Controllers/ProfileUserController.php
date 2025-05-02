<?php

declare(strict_types=1);

namespace App\Admin\User\Http\Controllers;

use App\Admin\Models\User;
use App\Admin\Common\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;

final class ProfileUserController extends Controller
{
    public function __invoke(User $user): Renderable
    {
        return view('admin::user.profile', ['user' => $user]);
    }
}
