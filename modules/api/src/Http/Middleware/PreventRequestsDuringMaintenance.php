<?php

declare(strict_types=1);

namespace App\Api\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
