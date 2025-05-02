<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Controllers;

use App\Admin\Common\Enums\ResourseType;
use App\Admin\Seo\Services\DomainSeoService;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class DomainSeoCommonController extends DomainSeoBaseController
{
    /**
     * @throws Exception
     */
    public function __invoke(Request $request): Renderable|RedirectResponse
    {
        $data = null;

        /** @var string $title */
        $title = $request->title;

        /** @var string $title */
        $type = $request->type2;

        if ($title) {
            /** @var  ?Collection $data */
            $data = match ($type) {
                'movie' => (new DomainSeoService())->getDataTagForTitle(ResourseType::MOVIE->value, $title),
                'series' => (new DomainSeoService())->getDataTagForTitle(ResourseType::SERIES->value, $title),
                'season' => (new DomainSeoService())->getDataTagForTitle(ResourseType::SEASON->value, $title),
                'episode' => (new DomainSeoService())->getDataTagForTitle(ResourseType::EPISODE->value, $title),
                default => throw new Exception('Unexpected match value'),
            };

            if (! $data instanceof Collection && request()->method() === 'POST') {
                return redirect()->back()->withErrors([self::FAILED]);
            }

            if ($data !== null) {
                return match ($type) {
                    'movie' => $this->response('seo::category.movie', $data, $title),
                    'series' => $this->response('seo::category.series', $data, $title),
                    'season' => $this->response('seo::category.season', $data, $title),
                    'episode' => $this->response('seo::category.episode', $data, $title),
                    default => throw new Exception('Unexpected match value'),
                };
            }
        }

        return view('seo::common', ['data' => $data, 'title' => $title]);
    }

    private function response(string $view, Collection $data, string $title): Renderable
    {
        return view($view, ['data' => $data, 'title' => $title]);
    }
}
