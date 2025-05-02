<?php

declare(strict_types=1);

namespace App\Admin\Common\Actions\Common;

use App\Admin\Common\Enums\ResourseType;
use App\Admin\Seo\Repositories\MovieRepository;
use App\Admin\Seo\Repositories\SeriesRepository;
use App\Api\Models\Episode;
use App\Api\Models\Movie;
use App\Api\Models\Season;
use App\Api\Models\Series;

use function is_int;
use function is_string;

final class FullUrlAction extends BaseAction
{
    public function handle(int $id, string $category): string|null
    {
        $model = $this->getModel($category, $id);

        if (! $model) {
            return null;
        }

        return $this->getUrl($category, $model);
    }

    private function getUrl(string $category, mixed $model): string|null
    {
        $url = null;
        $slug = null;

        if (
            ($category === ResourseType::SEASON->value && $model instanceof Season)
            || ($category === ResourseType::EPISODE->value && $model instanceof Episode)
        ) {
            if (! isset($model->series_id) || ! is_int($model->series_id)) {
                return null;
            }

            $series = (new SeriesRepository())->getSeriesById($model->series_id);

            if (! $series instanceof Series) {
                return null;
            }

            $slug = isset($series->slug) && is_string($series->slug) ? $series->slug : null;

            if ($slug === null) {
                return null;
            }
        }

        $type = $this->getType($category);

        if (! is_string($type)) {
            return null;
        }

        if (
            $category === ResourseType::MOVIE->value && $model instanceof Movie
            || $category === ResourseType::SERIES->value && $model instanceof Series
        ) {
            if (! isset($model->slug) || ! is_string($model->slug)) {
                return null;
            }

            $url = $type . $model->slug;
        }

        if ($category === ResourseType::SEASON->value && $model instanceof Season && $slug !== null) {
            $url = $type . $slug . '/' . 'season-' . $model->slug;
        }

        if ($category === ResourseType::EPISODE->value && $model instanceof Episode && $slug !== null) {
            $season = (new SeriesRepository())->getSeasonById(id: $model->season_id);

            if (! $season instanceof Season) {
                return null;
            }

            $url = $type . $slug . '/' . 'season-' . $season->slug . '/' . 'episode-' . $model->slug;
        }

        return $url;
    }

    private function getModel(string $category, int $id): mixed
    {
        return match ($category) {
            ResourseType::MOVIE->value => (new MovieRepository())->getMovieById($id),
            ResourseType::SERIES->value => (new SeriesRepository())->getSeriesById($id),
            ResourseType::SEASON->value => (new SeriesRepository())->getSeasonById($id),
            ResourseType::EPISODE->value => (new SeriesRepository())->getEpisodeById($id),
            default => null,
        };
    }

    private function getType(string $category): string|null
    {
        return match ($category) {
            ResourseType::MOVIE->value => '/movies/',
            ResourseType::SERIES->value, ResourseType::SEASON->value, ResourseType::EPISODE->value => '/tvseries/',
            default => null,
        };
    }
}
