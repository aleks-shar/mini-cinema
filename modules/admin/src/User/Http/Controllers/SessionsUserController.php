<?php

declare(strict_types=1);

namespace App\Admin\User\Http\Controllers;

use App\Admin\Common\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;

final class SessionsUserController extends Controller
{
    public function __invoke(): Renderable
    {
        DB::query()->from('sessions')->whereNull('user_id')->delete();

        return view('admin::user.sessions', ['data' => DB::query()->from('sessions')->paginate(50)]);
    }
}
