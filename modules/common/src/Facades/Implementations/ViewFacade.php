<?php

declare(strict_types=1);

namespace App\Admin\Common\Facades\Implementations;

use App\Admin\Models\User;
use App\Admin\Common\Enums\ResourseType;
use App\Admin\Seo\Repositories\MovieRepository;
use App\Admin\Seo\Repositories\SeriesRepository;
use App\Api\Models\Episode;
use App\Api\Models\Movie;
use App\Api\Models\Season;
use App\Api\Models\Series;
use Illuminate\Support\Facades\Cache;

use function is_int;
use function is_string;

final readonly class ViewFacade
{
    public static function getTitle(int $id, string $category): string|null
    {
        $title = null;

        $model = self::getModel($id, $category);

        if ($category === ResourseType::EPISODE->value && $model instanceof Episode) {
            $id = $model->season_id;
            $season = (new SeriesRepository())->getSeasonById($id);

            if (! $season instanceof Season) {
                return null;
            }

            $title = isset($season->title) && is_string($season->title) ? $season->title : null;

            if ($title === null) {
                return null;
            }

            return $title;
        }

        if ($category === ResourseType::SEASON->value && $model instanceof Season) {
            $title = isset($model->title) ? $model->title : null;
        }

        if ($category === ResourseType::SERIES->value && $model instanceof Series) {
            $title = $model->title;
        }

        if ($category === ResourseType::MOVIE->value && $model instanceof Movie) {
            $title = $model->title;
        }

        if (! is_string($title)) {
            return null;
        }

        return $title;
    }

    public static function getModel(int $id, string $category): mixed
    {
        return match ($category) {
            ResourseType::MOVIE->value => (new MovieRepository())->getMovieById($id),
            ResourseType::SERIES->value => (new SeriesRepository())->getSeriesById($id),
            ResourseType::SEASON->value => (new SeriesRepository())->getSeasonById($id),
            ResourseType::EPISODE->value => (new SeriesRepository())->getEpisodeById($id),
            default => null,
        };
    }

    public static function getSeriesTitleForEpisode(int $id): string|null
    {
        $episode = (new SeriesRepository())->getEpisodeById($id);

        if (! $episode instanceof Episode) {
            return null;
        }

        $episodeId = isset($episode->series_id) && is_int($episode->series_id) ? $episode->series_id : null;

        if ($episodeId === null) {
            return null;
        }

        $series = (new SeriesRepository())->getSeriesById($episodeId);

        if (! $series instanceof Series) {
            return null;
        }

        return $series->title;
    }

    public static function getSeasonIdForEpisode(int $id, string $category = null): int|null
    {
        if ($category === ResourseType::EPISODE->value) {
            $episode = (new SeriesRepository())->getEpisodeById($id);

            if (! $episode instanceof Episode) {
                return null;
            }

            $season = (new SeriesRepository())->getSeasonById($episode->season_id);

            if (! $season instanceof Season) {
                return null;
            }

            $seasonId = isset($season->part) && is_int($season->part) ? $season->part : null;

            if ($seasonId === null) {
                return null;
            }

            return $seasonId;
        }

        $season = (new SeriesRepository())->getSeasonById($id);

        if (! $season instanceof Season) {
            return null;
        }

        $seasonId = isset($season->part) && is_int($season->part) ? $season->part : null;

        if ($seasonId === null) {
            return null;
        }

        return $seasonId;
    }

    public static function getSeason(int $id, string $category): int|null
    {
        if ($category === ResourseType::SEASON->value) {
            $season = (new SeriesRepository())->getSeasonById($id);

            if (! $season instanceof Season) {
                return null;
            }

            $seasonPart = isset($season->part) && is_int($season->part) ? $season->part : null;

            if ($seasonPart === null) {
                return null;
            }

            return $seasonPart;
        }

        if ($category === ResourseType::EPISODE->value) {
            $episode = (new SeriesRepository())->getEpisodeById($id);

            if (! $episode instanceof Episode) {
                return null;
            }

            $season = (new SeriesRepository())->getSeasonById($episode->season_id);

            if ($season instanceof Season) {
                $seasonPart = isset($season->part) && is_int($season->part) ? $season->part : null;

                if ($seasonPart === null) {
                    return null;
                }

                return $seasonPart;
            }

            return null;
        }

        return null;
    }

    public static function getEpisode(int $id, string $category): int|null
    {
        $episode = null;

        if ($category === ResourseType::EPISODE->value) {
            $episode = (new SeriesRepository())->getEpisodeById($id);
        }

        if (! $episode instanceof Episode) {
            return null;
        }

        return $episode->part;
    }

    public static function getUserNameByEmail(?string $email): mixed
    {
        return Cache::remember($email . '_email', 60 * 60, function () use ($email) {
            if ($email === null) {
                return null;
            }

            $user = User::query()->where('email', $email)->first();

            if (! $user instanceof User) {
                return 'Unknown';
            }

            return $user->name;
        });
    }

    public static function getUserNameById(int $id): string
    {
        return Cache::remember($id . '_user_name_for_id', 60 * 60, function () use ($id) {
            $user = User::query()->where('id', $id)->first();

            if (! $user instanceof User) {
                return 'Unknown';
            }

            return $user->name;
        });
    }

    public static function getUserEmailById(int $id): string
    {
        return Cache::remember($id . '_user_email_for_id', 60 * 60, function () use ($id) {
            $user = User::query()->where('id', $id)->first();

            if (! $user instanceof User) {
                return 'Unknown';
            }

            return $user->email;
        });
    }
}
