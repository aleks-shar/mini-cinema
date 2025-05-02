<?php

declare(strict_types=1);

use App\Admin\Common\Facades\AppView;
use Illuminate\Support\Facades\Facade;

return [
    'pagination' => env('PAGINATION', 50),
    'aliases' => Facade::defaultAliases()->merge([
        'AppView' => AppView::class,
    ])->toArray(),
];
