<?php

declare(strict_types=1);

namespace App\Admin\Seo\Actions\Series;

use App\Admin\Common\Enums\ResourseType;
use App\Admin\Seo\Repositories\SeriesRepository;
use App\Api\Models\Episode;
use App\Api\Models\Season;
use App\Api\Models\Series;

use function count;
use function explode;
use function intval;
use function is_int;

final class MetaDataForSeriesAction extends BaseAction
{
    /** @return array<string, int|string|mixed> */
    public function handle(string $uri): array
    {
        $data = [];

        $parts = explode('/', $uri);

        if (count($parts) === 1) {
            $series = $this->getSeries($parts[0]);

            if (! $series) {
                return [];
            }

            $data = [
                'id' => $series->id,
                'category' => ResourseType::SERIES->value,
            ];
        }

        if (count($parts) === 2) {
            $seasonNumber = intval(substr($parts[1], 7));

            $series = $this->getSeries($parts[0]);

            if (! $series instanceof Series) {
                return [];
            }

            if (! $seasonNumber) {
                return [];
            }

            $seriesId = isset($series->id) && is_int($series->id) ? $series->id : null;

            if ($seriesId === null) {
                return [];
            }

            $season = $this->getSeason($seasonNumber, $seriesId);

            if (! $season) {
                return [];
            }

            $data = [
                'id' => $season->id,
                'category' => ResourseType::SEASON->value,
            ];
        }

        if (count($parts) === 3) {
            $seasonNumber = intval(substr($parts[1], 7));
            $episodeNumber = intval(substr($parts[2], 8));
            $series = $this->getSeries($parts[0]);

            if (! $series instanceof Series) {
                return [];
            }

            if (! $seasonNumber) {
                return [];
            }

            $seriesId = isset($series->id) && is_int($series->id) ? $series->id : null;

            if ($seriesId === null) {
                return [];
            }

            $season = $this->getSeason($seasonNumber, $seriesId);

            if (! $season instanceof Season) {
                return [];
            }

            $seasonId = isset($season->id) && is_int($season->id) ? $season->id : null;

            if ($seasonId === null) {
                return [];
            }

            $episode = (new SeriesRepository())
                ->getEpisode($episodeNumber, $seasonId, $seriesId);

            if (! $episode instanceof Episode) {
                return [];
            }

            if (! isset($episode->id) || ! is_int($episode->id)) {
                return [];
            }

            $data = [
                'id' => $episode->id,
                'category' => ResourseType::EPISODE->value,
            ];
        }

        return $data;
    }
}
