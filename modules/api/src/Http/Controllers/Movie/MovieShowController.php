<?php

declare(strict_types=1);

namespace App\Api\Http\Controllers\Movie;

use App\Admin\Seo\Models\MetaTag;
use App\Api\Http\Controllers\Controller;
use App\Api\Traits\SeoParams;
use App\Api\Helpers\SeoDataPrepare;
use App\Api\Http\Resources\MovieResource;
use App\Api\Models\Movie;
use App\Api\Repositories\MovieRepository;
use App\Api\Services\SeoService;
use Illuminate\Http\Request;
use Throwable;

final class MovieShowController extends Controller
{
    use SeoParams;

    /**
     * Получение фильма по slug
     *
     * @throws Throwable
     */
    public function __invoke(Request $request, SeoService $seoService, MovieRepository $movieRepository): mixed
    {
        /** @var Movie $movie */
        $movie = $movieRepository->getItem($request->route('movie'));
        abort_if(! $movie, 404, 'Movie not found.');
        abort_if($movie->is_abuse !== 0, 451, 'Закрыто по требованию правообладателей.');
        $resource = new MovieResource($movie);
        /** @var MetaTag $tag */
        $tag = MetaTag::query()->where(['entity_id' => $movie->id, 'entity_type' => 'movie'])->first();

        $resource->additional([
            'seo' => $seoService->getSeoData($this->getSeoHostSettings($tag), SeoDataPrepare::getSeoDataForMovie($movie)),
        ]);

        return $this->responseWithCache('movie-' . $movie->slug . ' - ' . time(), $resource);
    }
}
