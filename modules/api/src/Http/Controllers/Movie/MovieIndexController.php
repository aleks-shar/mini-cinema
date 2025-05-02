<?php

declare(strict_types=1);

namespace App\Api\Http\Controllers\Movie;

use App\Api\Http\Controllers\Controller;
use App\Api\Traits\SeoParams;
use App\Api\Helpers\SeoDataPrepare;
use App\Api\Http\Resources\MovieResource;
use App\Api\Repositories\MovieRepository;
use App\Api\Services\SeoService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

final class MovieIndexController extends Controller
{
    use SeoParams;

    /**
     * Список фильмов
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(SeoService $seoService, MovieRepository $movieRepository): mixed
    {
        $resource = MovieResource::collection($movieRepository->getList());
        $resource->additional([
            'seo' => $seoService->getSeoData($this->getSeoHostSettings(), SeoDataPrepare::getSeoDataForMovieList()),
        ]);

        return $this->responseWithCache('movie-list-' . time(), $resource);
    }
}
