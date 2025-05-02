<?php

declare(strict_types=1);

namespace App\Admin\User\Http\Controllers;

use App\Admin\Common\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

final class DeleteOneSessionsUserController extends Controller
{
    public function __invoke(string $id): RedirectResponse
    {
        DB::query()->from('sessions')->where('id', $id)->delete();

        return redirect()->route('admin.user.sessions');
    }
}
