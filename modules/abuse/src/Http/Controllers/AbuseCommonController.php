<?php

declare(strict_types=1);

namespace App\Admin\Abuse\Http\Controllers;

use App\Admin\Abuse\Http\Requests\TitleRequest;
use App\Admin\Abuse\Services\AbuseService;
use App\Admin\Common\Enums\ResourseType;
use App\Admin\Common\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;

final class AbuseCommonController extends Controller
{
    public function __construct(
        private readonly AbuseService $service,
    ) {
        parent::__construct();
    }

    public function __invoke(TitleRequest $request): Renderable|RedirectResponse
    {
        /** @var ?string $title */
        $title = $request->validated('title') ?? null;
        /** @var string $type */
        $type = $request->validated('type2') ?? null;

        if ($title) {
            /** @var ?Collection $data */
            $data = match ($type) {
                'movie' => is_string($title) ? $this->service->getDataForTitle(ResourseType::MOVIE->value, $title)
                    : null,
                'series' => is_string($title)
                    ? $this->service->getDataForTitle(ResourseType::SERIES->value, $title)
                    : null,
                'season' => is_string($title)
                    ? $this->service->getDataForTitle(ResourseType::SEASON->value, $title)
                    : null,
                'episode' => is_string($title)
                    ? $this->service->getDataForTitle(ResourseType::EPISODE->value, $title)
                    : null,
            };

            if (! $data && request()->method() === 'POST') {
                return redirect()->back()->withErrors(['Название не может быть пустым']);
            }

            if ($data !== null) {
                return match ($type) {
                    'movie' => $this->response('abuse::category.movie.main', $data, $title),
                    'series' => $this->response('abuse::category.series.main', $data, $title),
                    'season' => $this->response('abuse::category.season.main', $data, $title),
                    'episode' => $this->response('abuse::category.episode.main', $data, $title),
                };
            }
        }

        return view('abuse::common.main', ['data' => null, 'title' => $title]);
    }

    private function response(string $view, Collection $data, string $title): Renderable
    {
        return view($view, ['data' => $data, 'title' => $title]);
    }
}
