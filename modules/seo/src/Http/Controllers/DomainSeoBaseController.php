<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Controllers;

use App\Admin\Common\Enums\ResourseType;
use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\Seo\Http\Requests\Seo\SeoUriRequest;
use App\Admin\Seo\Repositories\MovieRepository;
use App\Admin\Seo\Repositories\SeriesRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;

abstract class DomainSeoBaseController extends Controller
{
    /**
     * @return array<string, mixed>|RedirectResponse
     */
    protected function checkDataFromSeoUriRequest(SeoUriRequest $request): array|RedirectResponse
    {
        /** @var array<string, mixed> $data */
        $data = $request->validated();

        return $data;
    }

    protected function getData(string $category, string $uri): ?Model
    {
        return match ($category) {
            ResourseType::MOVIE->value => (new MovieRepository())->getMovieBySlug($uri),
            ResourseType::SERIES->value => (new SeriesRepository())->getSeriesBySlug($uri),
            default => null,
        };
    }
}
