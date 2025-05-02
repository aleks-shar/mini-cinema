<?php

declare(strict_types=1);

namespace App\Admin\Seo\Actions\Series;

use App\Admin\Common\Enums\ResourseType;
use App\Admin\Seo\Repositories\SeriesRepository;
use App\Api\Models\Season;
use App\Api\Models\Series;

abstract class BaseAction
{
    protected function getSeries(string $slug): Series|null
    {
        $series = (new SeriesRepository())->getSeriesBySlug($slug);

        if (! $series instanceof Series) {
            return null;
        }

        return $series;
    }

    protected function getSeason(int $part, int $seriesId): Season|null
    {
        $season = (new SeriesRepository())->getSeasonId($part, $seriesId);

        if (! $season instanceof Season) {
            return null;
        }

        return $season;
    }

    protected function getData(int $id, string $category): mixed
    {
        return match ($category) {
            ResourseType::SERIES->value => (new SeriesRepository())
                ->getSeriesById($id),
            ResourseType::SEASON->value => (new SeriesRepository())
                ->getSeasonById($id),
            ResourseType::EPISODE->value => (new SeriesRepository())
                ->getEpisodeById($id),
            default => null,
        };
    }
}
