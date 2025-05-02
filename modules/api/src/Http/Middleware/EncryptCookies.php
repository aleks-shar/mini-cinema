<?php

declare(strict_types=1);

namespace App\Api\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
