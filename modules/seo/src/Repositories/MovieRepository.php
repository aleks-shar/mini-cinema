<?php

declare(strict_types=1);

namespace App\Admin\Seo\Repositories;

use App\Admin\Common\Repositories\BaseRepository;
use App\Api\Models\Movie;
use Illuminate\Database\Eloquent\Collection;

final class MovieRepository extends BaseRepository
{
    public function getMovieBySlug(string $uri): ?Movie
    {
        /** @var Movie */
        return Movie::query()->where(['slug' => $uri])->first();
    }

    public function getMovieByTitle(string $title): ?Collection
    {
        return Movie::query()->where('title', 'like', "%$title%")->get();
    }

    public function getMovieById(int $id): ?Movie
    {
        /** @var Movie */
        return Movie::query()->where(['id' => $id])->first();
    }
}
