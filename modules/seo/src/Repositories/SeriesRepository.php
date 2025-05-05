<?php

declare(strict_types=1);

namespace App\Admin\Seo\Repositories;

use App\Admin\Common\Repositories\BaseRepository;
use App\Api\Models\Episode;
use App\Api\Models\Season;
use App\Api\Models\Series;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

final class SeriesRepository extends BaseRepository
{
    public function getSeriesBySlug(string $uri): ?Model
    {
        return Series::query()->where(['slug' => $uri])->first();
    }

    public function getSeriesByTitle(string $title): ?Collection
    {
        return Series::query()->where('title', 'like', "%$title%")->get();
    }

    public function getSeasonById(int $id): mixed
    {
        return cache()->remember('SeriesRepository_getSeasonById_' . $id, self::TTL, function () use ($id) {
            return Season::query()->where(['id' => $id])->first();
        });
    }

    public function getEpisodeById(int $id): mixed
    {
        return cache()->remember('SeriesRepository_getEpisodeById_' . $id, self::TTL, function () use ($id) {
            return Episode::query()->where(['id' => $id])->first();
        });
    }

    public function getSeriesById(int $id): mixed
    {
        return cache()->remember('SeriesRepository_getSeriesById_' . $id, self::TTL, function () use ($id) {
            return Series::query()->where(['id' => $id])->first();
        });
    }

    public function getSeasonId(int $part, int $series_id): ?Model
    {
        return Season::query()->where(['part' => $part, 'series_id' => $series_id])->first();
    }

    public function getSeasonByTitle(string $title): ?Collection
    {
        return Season::query()->where('title', 'like', "%$title%")->get();
    }

    public function getEpisode(int $episode_number, int $season_id, int $series_id): ?Model
    {
        return Episode::query()->where(['part' => $episode_number, 'season_id' => $season_id, 'series_id' => $series_id])
            ->first();
    }

    public function getEpisodeByTitle(string $title): ?Collection
    {
        return Episode::query()->where('title', 'like', "%$title%")->get();
    }
}
