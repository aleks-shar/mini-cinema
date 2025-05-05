<?php

declare(strict_types=1);

namespace App\Api\Repositories;

use App\Api\Models\Series;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\Paginator;

final class SeriesRepository
{
    public function getList(): Paginator
    {
        return Series::query()
            ->where(['is_abuse' => 0])
            ->simplePaginate();
    }

    public function getItem(mixed $series): ?Model
    {
        return Series::query()
            ->where(['is_abuse' => 0])
            ->where('series.slug', $series)
            ->first();
    }
}
