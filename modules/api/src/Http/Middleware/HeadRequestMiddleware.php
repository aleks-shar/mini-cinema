<?php

declare(strict_types=1);

namespace App\Api\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HeadRequestMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->isMethod('head')) {
            $jsonResponse = response()->json(['status' => 'ok']);
            $jsonResponse->header('Content-Type', 'application/json');

            return $jsonResponse;
        }

        return $next($request);
    }
}
