<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Controllers;

use App\Admin\Common\Enums\ResourseType;
use App\Admin\Seo\Models\MetaTag;
use App\Admin\Seo\Repositories\SeoRepository;
use App\Admin\Seo\Repositories\SeriesRepository;
use App\Admin\Seo\Services\MetaTagService;
use App\Api\Traits\SeoParams;
use App\Api\Helpers\SeoDataPrepare;
use App\Api\Http\Resources\SeoResource;
use App\Api\Models\Episode;
use App\Api\Models\Movie;
use App\Api\Models\Season;
use App\Api\Models\Seo;
use App\Api\Models\Series;
use App\Api\Services\SeoService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

use function is_array;
use function is_int;

final class EditDomainSeoController extends DomainSeoBaseController
{
    use SeoParams;

    public function __invoke(string $category, string $uri, int $idd): Renderable|RedirectResponse
    {
        $data = match ($category) {
            ResourseType::MOVIE->value,
            ResourseType::SERIES->value => $this->getData($category, $uri),
            ResourseType::SEASON->value => (new SeriesRepository())->getSeasonById($idd),
            ResourseType::EPISODE->value => (new SeriesRepository())->getEpisodeById($idd),
            default => null,
        };

        if (! $data) {
            return redirect()->back()->withErrors([self::FAILED]);
        }

        $dataId = null;

        if (
            $data instanceof Movie
            || $data instanceof Series
            || $data instanceof Episode
            || $data instanceof Season
        ) {
            $dataId = isset($data->id) && is_int($data->id) ? $data->id : null;
        }

        if ($dataId === null) {
            return redirect()->back()->withErrors([self::FAILED]);
        }

        $tag = (new MetaTagService())->getMetaTagById($dataId, $category);

        if (! $tag instanceof MetaTag) {
            /** @var Seo $tag */
            $tag = $this->getTag($category);
        }

        $response = $this->getDataForResponse($category, $data, $tag);

        if (! is_array($response) || empty($response)) {
            return redirect()->back()->withErrors([self::FAILED]);
        }

        return view(
            'seo::edit-individual',
            [
                'data' => $data,
                'category' => $category,
                'uri' => $response['uri'],
                'tags' => $tag,
                'apiTags' => $response['api'] ?? null,
            ]
        );
    }

    private function getTag(string $category): ?Model
    {
        return match ($category) {
            ResourseType::MOVIE->value => (new SeoRepository())->getSeoByAlias('movie_get'),
            ResourseType::SERIES->value => (new SeoRepository())->getSeoByAlias('series_get'),
            ResourseType::SEASON->value => (new SeoRepository())->getSeoByAlias('season_get'),
            ResourseType::EPISODE->value => (new SeoRepository())->getSeoByAlias('episode_get'),
            default => null,
        };
    }

    /**
     * @return array<string, mixed>|null
     */
    private function getDataForResponse(string $category, mixed $data, MetaTag|Seo $tag): ?array
    {
        $api = null;
        $uri = null;

        if ($data instanceof Movie || $data instanceof Series) {
            if (! isset($data->slug) || ! is_string($data->slug)) {
                return null;
            }

            $uri = $data->slug;
        }

        if ($category === ResourseType::SERIES->value && $data instanceof Series) {
            $api = $this->getApi($tag, null, null, $data);
        }

        if ($category === ResourseType::SEASON->value && $data instanceof Season) {
            $series = (new SeriesRepository())->getSeriesById((int)$data->series_id);

            if (! $series instanceof Series) {
                return null;
            }

            $uri = $series->slug . '?season=' . $data->slug;

            $api = $this->getApi($tag, $data->part, null, $series);
        }

        if ($category === ResourseType::EPISODE->value && $data instanceof Episode) {
            $series = (new SeriesRepository())->getSeriesById((int)$data->series_id);

            if (! $series instanceof Series) {
                return null;
            }

            $season = (new SeriesRepository())->getSeasonById((int)$data->season_id);

            $episodeNumber = intval($data->slug);

            $seasonNumber = intval($season?->slug);

            $uri = $series->slug . '?episode=' . $episodeNumber . '&season=' . $seasonNumber;

            $api = $this->getApi($tag, $seasonNumber, $episodeNumber, $series);
        }

        if ($category === ResourseType::MOVIE->value && $data instanceof Movie) {
            try {
                $api = (new SeoService())->getSeoData(
                    $this->getSeoHostSettings($tag),
                    SeoDataPrepare::getSeoDataForMovie($data)
                );
            } catch (NotFoundExceptionInterface | ContainerExceptionInterface $exception) {
                logger()->error($exception->getMessage());
            }
        }

        return ['api' => $api, 'uri' => $uri];
    }

    private function getApi(MetaTag|Seo $tag, ?int $seasonNumber, ?int $episodeNumber, Series $series): ?SeoResource
    {
        try {
            $api = (new SeoService())->getSeoData($this->getSeoHostSettings($tag), SeoDataPrepare::getSeoDataForSeries($seasonNumber, $episodeNumber, $series));
        } catch (NotFoundExceptionInterface | ContainerExceptionInterface $exception) {
            logger()->error($exception->getMessage());

            return null;
        }

        return $api;
    }
}
