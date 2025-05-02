<?php

declare(strict_types=1);

namespace App\Admin\Common\Traits;

use App\Admin\Common\Http\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method filter()
 */
trait Filterable
{
    public function scopeFilter(Builder $builder, FilterInterface $filter): Builder
    {
        $filter->apply($builder);

        return $builder;
    }
}
