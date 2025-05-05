<?php

declare(strict_types=1);

namespace App\Admin\Seo\Services;

use App\Admin\Models\User;
use App\Admin\Common\Enums\ResourseType;
use App\Admin\Common\Services\BaseService;
use App\Admin\Seo\Actions\Series\MetaDataForSeriesAction;
use App\Admin\Seo\Models\MetaTag;
use App\Admin\Seo\Repositories\MetaTagRepository;
use App\Admin\Seo\Repositories\MovieRepository;
use App\Admin\Seo\Repositories\SeriesRepository;
use App\Api\Models\Episode;
use App\Api\Models\Movie;
use App\Api\Models\Season;
use App\Api\Models\Series;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use function is_int;
use function is_string;
use function parse_url;
use function substr;

final class DomainSeoService extends BaseService
{
    public function getDataTagForTitle(string $category, string $title): ?Collection
    {
        return match ($category) {
            ResourseType::MOVIE->value => (new MovieRepository())->getMovieByTitle($title),
            ResourseType::SERIES->value => (new SeriesRepository())->getSeriesByTitle($title),
            ResourseType::SEASON->value => (new SeriesRepository())->getSeasonByTitle($title),
            ResourseType::EPISODE->value => (new SeriesRepository())->getEpisodeByTitle($title),
            default => null,
        };
    }

    /**
     * @param array<array-key, mixed> $data
     */
    public function individualStore(int $id, string $category, array $data): bool
    {
        /** @var string $h1 */
        $h1 = $data['h1'] ?? null;

        /** @var string $title */
        $title = $data['title'] ?? null;

        /** @var string $description */
        $description = $data['description'] ?? null;

        /** @var string $keywords */
        $keywords = $data['keywords'] ?? null;

        $name = 'nobody';
        $uri = '/';
        $seasonPart = null;
        $episodePart = null;

        if ($category === ResourseType::MOVIE->value) {
            $movie = (new MovieRepository())->getMovieById($id);

            if (! $movie instanceof Movie) {
                return false;
            }

            $name = $movie->title;
            $uri = isset($movie->slug) && is_string($movie->slug) ? $movie->slug : null;
        }

        if ($category === ResourseType::SERIES->value) {
            $series = (new SeriesRepository())->getSeriesById($id);

            if (! $series instanceof Series) {
                return false;
            }

            $name = isset($series->title) && is_string($series->title) ? $series->title : null;
            $uri = isset($series->slug) && is_string($series->slug) ? $series->slug : null;
        }

        if ($category === ResourseType::SEASON->value) {
            $season = (new SeriesRepository())->getSeasonById($id);

            if (! $season instanceof Season) {
                return false;
            }

            $name = isset($season->title) && is_string($season->title) ? $season->title : null;
            $seasonId = isset($season->series_id) && is_int($season->series_id) ? $season->series_id : null;

            if ($seasonId === null) {
                return false;
            }

            $series = (new SeriesRepository())->getSeriesById($seasonId);

            if (! $series instanceof Series) {
                return false;
            }

            $seasonTitle = isset($season->title) && is_string($season->title) ? $season->title : null;
            $seasonPart = isset($season->part) && is_int($season->part) ? $season->part : null;
            $seasonParts = isset($season->parts) && is_int($season->parts) ? $season->parts : null;

            if ($seasonTitle === null || $seasonPart === null || $seasonParts === null) {
                return false;
            }

            $slug = $seasonTitle . $seasonPart . $seasonParts;

            $uri = Str::slug($slug);
        }

        if ($category === ResourseType::EPISODE->value) {
            $episode = (new SeriesRepository())->getEpisodeById($id);

            if (! $episode instanceof Episode) {
                return false;
            }

            $name = isset($episode->title) && is_string($episode->title) ? $episode->title : null;
            /** @var int|null $seriesId */
            $seriesId = isset($episode->series_id) ? $episode->series_id : null;

            if ($seriesId === null) {
                return false;
            }

            $series = (new SeriesRepository())->getSeriesById($seriesId);

            if (! $series instanceof Series) {
                return false;
            }

            $season = (new SeriesRepository())->getSeasonById($seriesId);

            if (! $season instanceof Season) {
                return false;
            }

            $episodeTitle = isset($episode->title) && is_string($episode->title) ? $episode->title : null;
            $episodeId = isset($episode->id) && is_int($episode->id) ? $episode->id : null;

            if ($episodeTitle === null || $episodeId === null) {
                return false;
            }

            $slug = $episodeTitle . $episode->part . $episodeId;

            $uri = Str::slug($slug);

            /** @var int $seasonPart */
            $seasonPart = $season->part;

            /** @var int $episodePart */
            $episodePart = $episode->part;
        }

        /** @var User $user */
        $user = auth()->guard('admin')->user();

        $email = $user->email;

        /** @var array<string, string> $data */
        $data = [
            'title' => $title,
            'keywords' => $keywords,
            'email' => $email,
            'description' => $description,
            'h1' => $h1,
            'uri' => $uri,
            'name' => $name,
            'id' => $id,
            'category' => $category,
            'season' => $seasonPart ?? null,
            'episode' => $episodePart ?? null,
        ];

        $tag = (new MetaTagRepository())->getMetaTagById($id, $category);

        if ($tag instanceof MetaTag && (new MetaTagRepository())->individualUpdate($tag, $data)) {
            return true;
        }

        if (! (new MetaTagRepository())->individualStore($data)) {
            return false;
        }

        return true;
    }

    public function templateStore(int $id, string $category): bool
    {
        $tag = (new MetaTagRepository())->getMetaTagById($id, $category);

        if (! $tag instanceof MetaTag) {
            return false;
        }

        if (! (new MetaTagRepository())->templateStore($tag)) {
            return false;
        }

        return true;
    }

    public function destroyMetaTag(MetaTag $tag): bool
    {
        return (new MetaTagRepository())->destroy($tag);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function moviePost(array $data): ?Movie
    {
        $uri = $data['uri'];

        if (! is_string($uri)) {
            return null;
        }

        /** @var array<array-key, string> $params */
        $params = $this->prepare($uri, 8);

        return (new MovieRepository())->getMovieBySlug($params['uri']);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function seriesPost(array $data): ?Model
    {
        $uri = $data['uri'];

        if (! is_string($uri)) {
            return null;
        }

        /** @var array<array-key, string> $params */
        $params = $this->prepare($uri, 10);

        return (new SeriesRepository())->getSeriesBySlug($params['uri']);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>|null
     */
    public function seasonPost(array $data): ?array
    {
        $uri = $data['uri'];

        if (! is_string($uri)) {
            return null;
        }

        /** @var array<array-key, string> $params */
        $params = $this->prepare($uri, 10);

        $result = (new MetaDataForSeriesAction())->handle($params['uri']);

        $resultId = $result['id'];

        if (! is_int($resultId)) {
            return null;
        }

        /** @var Season $season */
        $season = (new SeriesRepository())->getSeasonById($resultId);

        return ['season' => $season];
    }

    /**
     * @param array<string, mixed> $data
     * @return ?array<string, mixed>
     */
    public function episodePost(array $data): ?array
    {
        $uri = isset($data['uri']) && is_string($data['uri']) ? $data['uri'] : null;

        if ($uri === null) {
            return null;
        }

        /** @var array<array-key, string> $params */
        $params = $this->prepare($uri, 10);

        $result = (new MetaDataForSeriesAction())->handle($params['uri']);

        $resultId = $result['id'];

        if (! is_int($resultId)) {
            return null;
        }

        $episode = (new SeriesRepository())->getEpisodeById($resultId);

        return ['episode' => $episode];
    }

    /** @return ?array<string, mixed> */
    public function prepare(string $uri, int $offset): ?array
    {
        $parseUri = parse_url($uri);

        $path = $parseUri['path'] ?? null;

        if ($path === null) {
            return null;
        }

        $uri = substr($path, $offset);

        return ['uri' => $uri];
    }
}
