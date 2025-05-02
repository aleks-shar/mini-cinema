<?php

declare(strict_types=1);

namespace App\Api\Http\Controllers\Series;

use App\Admin\Seo\Actions\Series\MetaDataForSeriesAction;
use App\Admin\Seo\Models\MetaTag;
use App\Api\Http\Controllers\Controller;
use App\Api\Traits\SeoParams;
use App\Api\Helpers\SeoDataPrepare;
use App\Api\Http\Requests\SeriesGetRequest;
use App\Api\Http\Resources\SeriesResource;
use App\Api\Models\Episode;
use App\Api\Models\Season;
use App\Api\Models\Series;
use App\Api\Repositories\SeriesRepository;
use App\Api\Services\SeoService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

final class SeriesShowController extends Controller
{
    use SeoParams;

    /**
     * Получение сериала по slug (передача номера сезона и эпизода выдаст запрашиваемый ресурс))
     *
     * @throws Throwable
     */
    public function __invoke(
        SeriesGetRequest $request,
        SeriesRepository $seriesRepository,
        SeoService $seoService,
    ): mixed {

        /** @var Series $series */
        $series = $seriesRepository->getItem($request->route('series'));

        abort_if(! $series, 404, 'Series not found.');

        abort_if($series->is_abuse !== 0, 451, 'Закрыто по требованию правообладателей.');

        $resource = new SeriesResource($series);

        $season = $request->query('season') ?? 1;

        if (! $series->seasons->contains('part', $season)) {
            throw new NotFoundHttpException('Season not found.');
        }

        /** @var Season $season */
        $seasonFromDB = Season::query()->where(['part' => $season, 'series_id' => $series->id])->first();

        abort_if($seasonFromDB->is_abuse !== 0, 451, 'Закрыто по требованию правообладателей.');

        $episode = $request->query('episode');

        if (
            $episode && ! $series->seasons->firstWhere('part', $season)
                ->episodes->contains('part', $episode)
        ) {
            throw new NotFoundHttpException('Episode not found.');
        }

        if ($episode) {
            /** @var Episode $episodeFromDB */
            $episodeFromDB = Episode::query()
                ->where(['part' => $episode, 'season_id' => $seasonFromDB->id, 'series_id' => $series->id])
                ->first();

            abort_if($episodeFromDB->is_abuse !== 0, 451, 'Закрыто по требованию правообладателей.');
        }

        $tag = null;

        if ($request->query('episode') === '0') {
            $episode = intval($request->query('episode'));
        }

        if ($episode && $season || $episode === 0 && $season) {
            $parts = explode('/', $request->path());
            $uri = $parts[2] . '/' . 'season-' . $season . '/' . 'episode-' . $episode;

            /** @var array $data */
            $data = (new MetaDataForSeriesAction())
                ->handle($uri);

            /** @var MetaTag $tag */
            $tag = MetaTag::query()
                ->where(['entity_id' => $data['id'], 'entity_type' => $data['category']])
                ->first();

            if ($tag) {
                $resource->additional([
                        'seo' => $seoService->getSeoData(
                            $this->getSeoHostSettings($tag),
                            SeoDataPrepare::getSeoDataForSeries($season, $episode, $series)
                        )]);

                return $resource->response()->getData(true);
            }

            $resource->additional([
                    'seo' => $seoService->getSeoDataByAlias(
                        $this->getSeoHostSettings($tag),
                        'episode_get',
                        SeoDataPrepare::getSeoDataForSeries($season, $episode, $series)
                    )]);

            return $resource->response()->getData(true);
        }

        if (! $episode && $season) {
            $parts = explode('/', $request->path());
            $uri = $parts[2] . '/' . 'season-' . $season;

            /** @var array $data */
            $data = (new MetaDataForSeriesAction())
                ->handle($uri);

            /** @var MetaTag $tag */
            $tag = MetaTag::query()
                ->where(['entity_id' => $data['id'], 'entity_type' => $data['category']])
                ->first();
        }

        if ($request->query('episode') === null && $request->query('season') === null) {

            /** @var array $data */
            $data = (new MetaDataForSeriesAction())
                ->handle($series->slug);

            /** @var MetaTag $tag */
            $tag = MetaTag::query()
                ->where(['entity_id' => $data['id'], 'entity_type' => $data['category']])
                ->first();
        }

        if ($tag) {
            $resource->additional([
                    'seo' => $seoService->getSeoData(
                        $this->getSeoHostSettings($tag),
                        SeoDataPrepare::getSeoDataForSeries($season, $episode, $series)
                    )]);

            return $this->responseWithCache('series-' . time(), $resource);
        }

        if ($request->query('season') === null) {
            $season = null;
        }

        $resource->additional([
                'seo' => $seoService->getSeoDataByAlias(
                    $this->getSeoHostSettings($tag),
                    ($episode ? 'episode_get' : ($season ? 'season_get' : 'series_get')),
                    SeoDataPrepare::getSeoDataForSeries($season, $episode, $series)
                )]);

        return $this->responseWithCache('series-' . time(), $resource);
    }
}
