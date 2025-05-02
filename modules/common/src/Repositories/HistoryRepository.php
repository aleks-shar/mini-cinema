<?php

declare(strict_types=1);

namespace App\Admin\Common\Repositories;

use App\Admin\Common\Http\Filters\HistoryAbuseFilter;
use App\Admin\Common\Http\Filters\HistoryCommonTagFilter;
use App\Admin\Common\Http\Filters\HistoryDomainSeoFilter;
use App\Admin\Common\Http\Filters\HistorySettingsFilter;
use App\Admin\Common\Models\HistoryAbuse;
use App\Admin\Common\Models\HistoryCommonTag;
use App\Admin\Common\Models\HistoryIndividualTag;
use App\Admin\Common\Models\HistorySetting;
use App\Admin\Setting\Http\Data\HistoryData;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

final class HistoryRepository extends BaseRepository
{
    /**
     * @param array<array-key, mixed> $data
     * @throws BindingResolutionException
     */
    public function getPaginateHistoryIndividualTag(array $data): Builder
    {
        return HistoryIndividualTag::query()
            ->filter(app()->make(HistoryDomainSeoFilter::class, ['queryParams' => array_filter($data)]))
            ->orderBy('updated_at', 'DESC');
    }

    public function getHistoryIndividualTagForId(int $id): HistoryIndividualTag|null
    {
        $result = HistoryIndividualTag::query()->where(['id' => $id])->first();

        if (! $result instanceof HistoryIndividualTag) {
            return null;
        }

        return $result;
    }

    /**
     * @param array<array-key, mixed> $data
     * @throws BindingResolutionException
     */
    public function getPaginateHistoryCommon(array $data): ?LengthAwarePaginator
    {
        return HistoryCommonTag::query()
            ->filter(app()->make(HistoryCommonTagFilter::class, ['queryParams' => array_filter($data)]))
            ->orderBy('updated_at', 'DESC')->paginate(self::PAGINATION);
    }

    public function getHistoryCommonForId(int $id): HistoryCommonTag|null
    {
        $result = HistoryCommonTag::query()->where(['id' => $id])->first();

        if (! $result instanceof HistoryCommonTag) {
            return null;
        }

        return $result;
    }

    /**
     * @param array<array-key, mixed> $data
     * @throws BindingResolutionException
     */
    public function getHistoryAbuseList(array $data): ?LengthAwarePaginator
    {
        $result = HistoryAbuse::query()
            ->filter(app()->make(HistoryAbuseFilter::class, ['queryParams' => array_filter($data)]))
            ->orderBy('updated_at', 'DESC')->paginate(self::PAGINATION);

        if (! $result instanceof LengthAwarePaginator) {
            return null;
        }

        return $result;
    }

    /**
     * @throws BindingResolutionException
     */
    public function getHistorySettingsList(HistoryData $data): ?LengthAwarePaginator
    {
        $result = HistorySetting::query()
            ->filter(app()->make(HistorySettingsFilter::class, ['queryParams' => array_filter($data->toArray())]))
            ->orderBy('updated_at', 'DESC')->paginate(self::PAGINATION);

        if (! $result instanceof LengthAwarePaginator) {
            return null;
        }

        return $result;
    }

    public function getOneHistorySettings(int $id): HistorySetting|null
    {
        $result = HistorySetting::query()->where('id', $id)->first();

        if (! $result instanceof HistorySetting) {
            return null;
        }

        return $result;
    }
}
