<?php

declare(strict_types=1);

namespace App\Api\Helpers;

use App\Api\Models\Movie;

final class SeoDataPrepare
{
    public static function getSeoDataForMovie(Movie $movie): array
    {
        return [
            '%name%' => ! empty($movie->title) ? $movie->title : $movie->title_original,
            '%year%' => $movie->year,
        ];
    }

    public static function getSeoDataForSeries($season, $episode, $series): array
    {
        return [
            '%season%' =>
                $season ? $season . ' сезон' : '',
            '%episode%' =>
                ($episode ? ($episode . ' серия') : ($episode === 0 ? '0 серия пилотный эпизод' : '')),
            '%name%' =>
                ! empty($series->title) ? $series->title : $series->title_original,
            '%year%' =>
                $series->year,
            '%description%' =>
                implode(' ', array_slice(explode(' ', $series->description), 0, 27)),
        ];
    }

    public static function getSeoDataForMovieList(): array
    {
        return ['%year%' => date('Y')];
    }

    public static function getSeoDataForSeriesList(): array
    {
        return ['%year%' => date('Y')];
    }
}
