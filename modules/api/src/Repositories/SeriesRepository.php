<?php

declare(strict_types=1);

namespace App\Api\Repositories;

use App\Api\Models\Series;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\AbstractPaginator;

final class SeriesRepository
{
    public function getList(): AbstractPaginator
    {
        return Series::query()
            ->where(['is_abuse' => 0])
            ->orderByRaw('popularity desc')
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
