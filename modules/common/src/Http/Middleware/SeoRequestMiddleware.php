<?php

declare(strict_types=1);

namespace App\Admin\Common\Http\Middleware;

use App\Admin\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class SeoRequestMiddleware
{
    /** @param Closure(Request): (Response) $next */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User $user */
        $user = Auth::guard('admin')->user();

        if ($user->role === 'admin') {
            return $next($request);
        }

        if (($user->role !== 'seo')) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
