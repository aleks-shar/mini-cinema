<?php

declare(strict_types=1);

namespace App\Api\Http\Controllers\Series;

use App\Api\Http\Controllers\Controller;
use App\Api\Traits\SeoParams;
use App\Api\Helpers\SeoDataPrepare;
use App\Api\Http\Resources\SeriesResource;
use App\Api\Repositories\SeriesRepository;
use App\Api\Services\SeoService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

final class SeriesIndexController extends Controller
{
    use SeoParams;

    /**
     * Список сериалов
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(
        SeriesRepository $seriesRepository,
        SeoService $seoService,
    ): mixed {
        $resource = SeriesResource::collection($seriesRepository->getList());
        $resource->additional([
                'seo' => $seoService->getSeoData($this->getSeoHostSettings(), SeoDataPrepare::getSeoDataForSeriesList()),
            ]);

        return $this->responseWithCache('series-list-' . time(), $resource);
    }
}
