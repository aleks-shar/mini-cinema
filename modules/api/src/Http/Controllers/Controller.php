<?php

declare(strict_types=1);

namespace App\Api\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    public const int|float CACHE_TIME = 60 * 60;

    protected function responseWithCache(string $key, mixed $resource)
    {
        return cache()->remember($key, self::CACHE_TIME, function () use ($resource) {
            return $resource->response()->getData(true);
        });
    }
}
