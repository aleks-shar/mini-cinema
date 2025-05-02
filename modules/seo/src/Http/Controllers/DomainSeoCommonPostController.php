<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Controllers;

use App\Admin\Common\Enums\ResourseType;
use App\Admin\Seo\Http\Requests\Seo\SeoUriRequest;
use App\Admin\Seo\Services\DomainSeoService;
use App\Api\Models\Episode;
use App\Api\Models\Movie;
use App\Api\Models\Season;
use App\Api\Models\Series;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

final class DomainSeoCommonPostController extends DomainSeoBaseController
{
    public function __invoke(SeoUriRequest $request): RedirectResponse
    {
        /** @var array<string, mixed> $data */
        $data = $this->checkDataFromSeoUriRequest($request);

        $type = isset($data['type']) && is_string($data['type']) ? $data['type'] : null;

        if ($type === null) {
            return redirect()->back()->withErrors([self::FAILED . '1']);
        }

        return match ($data['type']) {
            'movie' => $this->movie($data),
            'series' => $this->series($data),
            'season' => $this->season($data),
            'episode' => $this->episode($data),
            default => redirect()->back()->withErrors([self::FAILED])
        };
    }

    /**
     * @param array<string, mixed> $data
     */
    private function movie(array $data): RedirectResponse
    {
        $movie = (new DomainSeoService())->moviePost($data);
        $uri = isset($data['uri']) && is_string($data['uri']) ? $data['uri'] : null;

        if (! $movie instanceof Movie || ! is_string($uri)) {
            return redirect()->back()->withErrors([self::FAILED]);
        }

        if (! isset($movie->id) || ! isset($movie->slug)) {
            return redirect()->back()->withErrors([self::FAILED]);
        }

        return redirect()->route('seo.individual.edit', [ResourseType::MOVIE->value, $movie->slug, $movie->id]);
    }

    /**
     * @param array<string, mixed> $data
     */
    private function series(array $data): RedirectResponse
    {
        $series = (new DomainSeoService())->seriesPost($data);
        $uri = isset($data['uri']) && is_string($data['uri']) ? $data['uri'] : null;

        if (! $series instanceof Series || $uri === null) {
            return redirect()->back()->withErrors([self::FAILED]);
        }

        return redirect()->route('seo.individual.edit', [ResourseType::SERIES->value, $series->slug, $series->id]);
    }

    /**
     * @param array<string, mixed> $data
     */
    private function season(array $data): RedirectResponse
    {
        $array = (new DomainSeoService())->seasonPost($data);

        if (! is_array($array)) {
            return redirect()->back()->withErrors([self::FAILED]);
        }

        $season = $array['season'];

        if (! $season instanceof Season) {
            return redirect()->back()->withErrors([self::FAILED]);
        }

        $domainId = 1;

        if (isset($array['domain_id']) && is_int($array['domain_id'])) {
            $domainId = $array['domain_id'];
        }

        if (! $season->title || ! $season->part || ! $season->parts) {
            return redirect()->back()->withErrors([self::FAILED]);
        }

        $string = $season->title . $season->part . $season->parts;

        return redirect()->route('seo.individual.edit', [ResourseType::SEASON->value, Str::slug($string), $domainId, $season->id]);
    }

    /**
     * @param array<string, mixed> $data
     */
    private function episode(array $data): RedirectResponse
    {
        $array = (new DomainSeoService())->episodePost($data);

        if (! is_array($array)) {
            return redirect()->back()->withErrors([self::FAILED]);
        }

        $uri = isset($data['uri']) && is_string($data['uri']) ? $data['uri'] : null;
        $domainId = $array['domain_id'] && is_int($array['domain_id']) ? $array['domain_id'] : null;
        /** @var Episode $episode */
        $episode = $array['episode'];

        if ($uri === null || $domainId === null || ! $episode instanceof Episode) {
            return redirect()->back()->withErrors([self::FAILED]);
        }

        return redirect()->route('seo.individual.edit', [ResourseType::EPISODE->value, Str::slug($episode->title . $episode->part . $episode->id), $domainId, $episode->id]);
    }
}
