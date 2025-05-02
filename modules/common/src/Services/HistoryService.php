<?php

declare(strict_types=1);

namespace App\Admin\Common\Services;

use App\Admin\Common\Enums\ResourseType;
use App\Admin\Common\Facades\AppView;
use App\Admin\Common\Models\HistoryAbuse;
use App\Admin\Common\Models\HistorySetting;
use App\Admin\Common\Repositories\HistoryRepository;
use App\Admin\Models\User;
use App\Admin\Seo\Repositories\MovieRepository;
use App\Admin\Seo\Repositories\SeriesRepository;
use App\Admin\Setting\Models\DomainSettings;
use App\Api\Models\Episode;
use App\Api\Models\Movie;
use App\Api\Models\Season;
use App\Api\Models\Series;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

final class HistoryService extends BaseService
{
    public function __construct(
        private readonly HistoryRepository $repository,
    ) {
    }

    public function getHistoryIndividualTagForId(int $id): Builder|Model|null
    {
        return $this->repository->getHistoryIndividualTagForId(id: $id);
    }

    /**
     * @throws BindingResolutionException
     */
    public function getPaginateHistoryIndividualTag(mixed $data): LengthAwarePaginator|null
    {
        if (! is_array($data)) {
            return null;
        }

        return $this->repository->getPaginateHistoryIndividualTag($data)->paginate(10);
    }

    public function saveForCreateDomainSettings(DomainSettings $new): void
    {
        /** @var User $user */
        $user = Auth::guard('admin')->user();

        if (! $user instanceof User) {
            return;
        }

        HistorySetting::query()->create([
            'email' => $user->email,
            'action' => 'create',
            'tag_id' => $new->id,
            'new_key' => $new->key,
            'new_value' => $new->value,
            'new_description' => $new->description ?? null,
        ]);
    }

    public function saveForUpdateDomainSettings(DomainSettings $old, DomainSettings $new): void
    {
        /** @var User $user */
        $user = Auth::guard('admin')->user();

        if (! $user instanceof User) {
            return;
        }

        HistorySetting::query()->create([
            'email' => $user->email,
            'action' => 'update',
            'tag_id' => $new->id,
            'old_key' => $old->key,
            'new_key' => $new->key,
            'old_value' => $old->value,
            'new_value' => $new->value,
            'old_description' => $old->description ?? null,
            'new_description' => $new->description ?? null,
        ]);
    }

    public function saveForDeleteDomainSettings(DomainSettings $settings): void
    {
        /** @var User $user */
        $user = Auth::guard('admin')->user();

        if (! $user instanceof User) {
            return;
        }

        HistorySetting::query()->create([
            'email' => $user->email,
            'action' => 'delete',
            'tag_id' => $settings->id,
            'old_key' => $settings->key,
            'new_key' => $settings->key,
            'old_value' => $settings->value,
            'new_value' => $settings->value,
            'old_description' => $settings->description ?? null,
            'new_description' => $settings->description ?? null,
        ]);
    }

    public function abuse(int $id, string $category, bool $abuse): void
    {
        $model =  match ($category) {
            ResourseType::MOVIE->value => (new MovieRepository())->getMovieById($id),
            ResourseType::SERIES->value => (new SeriesRepository())->getSeriesById($id),
            ResourseType::SEASON->value => (new SeriesRepository())->getSeasonById($id),
            ResourseType::EPISODE->value => (new SeriesRepository())->getEpisodeById($id),
            default => null,
        };

        if (! $model) {
            return;
        }

        $title = null;
        $season = null;
        $episode = null;

        if (
            $category === ResourseType::MOVIE->value
            || $category === ResourseType::SERIES->value
        ) {
            if ($model instanceof Movie || $model instanceof Series) {
                $title = $model->title;
            }

            if ($title === null) {
                return;
            }
        }

        if ($category === ResourseType::SEASON->value) {
            if ($model instanceof Season) {
                $title = $model->title;
                $season = isset($model->part) && is_int($model->part) ? $model->part : null;
            }
        }

        if ($category === ResourseType::EPISODE->value) {
            if ($model instanceof Episode) {
                $episode = $model->part;
            }

            $season = AppView::getSeason($id, $category);
            $title = AppView::getTitle($id, $category);

            if ($title === null || $season === null || $episode === null) {
                return;
            }
        }

        /** @var User $user */
        $user = Auth::guard('admin')->user();

        if (! $user instanceof User) {
            return;
        }

        HistoryAbuse::query()->create([
            'email' => $user->email,
            'title' => $title,
            'type' => $category,
            'season' => $season,
            'episode' => $episode,
            'abuse' => $abuse,
        ]);
    }
}
