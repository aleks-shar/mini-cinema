<?php

declare(strict_types=1);

namespace App\Api\Repositories;

use App\Api\Models\Movie;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

final class MovieRepository
{
    public function getList(): Paginator
    {
        return Movie::query()
            ->where(['is_abuse' => 0])
            ->simplePaginate();
    }

    public function getItem(mixed $param): ?Model
    {
        return Movie::query()
            ->where(['is_abuse' => 0])
            ->where('movies.slug', $param)
            ->first();
    }
}
