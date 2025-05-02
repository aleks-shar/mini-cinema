<?php

declare(strict_types=1);

namespace App\Admin\User\Http\Controllers;

use App\Admin\Common\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

final class DeleteAllSessionsUserController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        DB::query()->from('sessions')->delete();

        dispatch(function () {
            DB::query()->from('sessions')->whereNull('user_id')->delete();
        });

        return redirect()->route('admin.user.sessions');
    }
}
