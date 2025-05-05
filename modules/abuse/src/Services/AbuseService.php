<?php

declare(strict_types=1);

namespace App\Admin\Abuse\Services;

use App\Admin\Abuse\Models\Abuse;
use App\Admin\Abuse\Repositories\AbuseRepository;
use App\Admin\Common\Enums\ResourseType;
use App\Admin\Common\Services\BaseService;
use App\Admin\Common\Repositories\HistoryRepository;
use App\Admin\Common\Services\HistoryService;
use App\Admin\Seo\Repositories\MovieRepository;
use App\Admin\Seo\Repositories\SeriesRepository;
use App\Api\Models\Episode;
use App\Api\Models\Movie;
use App\Api\Models\Season;
use App\Api\Models\Series;
use Auth;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

final class AbuseService extends BaseService
{
    public function __construct(
        private readonly AbuseRepository $repository,
        private readonly HistoryRepository $historyRepository,
        private readonly HistoryService $historyService,
    ) {
    }

    public function abuse(int $id, string $category): bool
    {
        $model = $this->getModelById($id, $category);

        if ($model === null) {
            return false;
        }

        /** @var Movie|Series|Season|Episode $model */
        $model->is_abuse = 1;
        $model->save();

        Abuse::query()->create([
            'model_id' => $model->id,
            'category' => $category,
            'is_abuse' => 1,
            'email' => auth()->guard('admin')->user()->email,
        ]);

        $this->historyService->abuse($model->id, $category, true);

        return true;
    }

    public function unAbuse(int $id, string $category): bool
    {
        $model = $this->getModelById($id, $category);

        if ($model === null) {
            return false;
        }

        /** @var Movie|Series|Season|Episode $model */
        $model->is_abuse = 0;
        $model->save();

        Abuse::query()->where(['model_id' => $model->id, 'category' => $category])->delete();

        $this->historyService->abuse($model->id, $category, false);

        return true;
    }

    public function getModelById(int $id, string $category): ?Model
    {
        return match ($category) {
            ResourseType::MOVIE->value => (new MovieRepository())->getMovieById($id),
            ResourseType::SERIES->value => (new SeriesRepository())->getSeriesById($id),
            ResourseType::SEASON->value => (new SeriesRepository())->getSeasonById($id),
            ResourseType::EPISODE->value => (new SeriesRepository())->getEpisodeById($id),
            default => null,
        };
    }

    public function getDataForTitle(string $category, string $title): Collection|null
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
     * @throws BindingResolutionException
     */
    public function allAbusesForFilter(array $data): ?LengthAwarePaginator
    {
        return $this->repository->abusedForFilter($data)->paginate(self::PAGINATION);
    }

    /**
     * @param array<array-key, mixed> $data
     * @throws BindingResolutionException
     */
    public function getHistoryAbuseList(array $data): ?LengthAwarePaginator
    {
        return $this->historyRepository->getHistoryAbuseList($data);
    }
}
