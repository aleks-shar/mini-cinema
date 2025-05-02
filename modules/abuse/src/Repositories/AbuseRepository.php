<?php

declare(strict_types=1);

namespace App\Admin\Abuse\Repositories;

use App\Admin\Abuse\Http\Filters\AllAbuseFilter;
use App\Admin\Abuse\Models\Abuse;
use App\Admin\Common\Repositories\BaseRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;

final class AbuseRepository extends BaseRepository
{
    /**
     * @param array<array-key, mixed> $data
     * @throws BindingResolutionException
     */
    public function abusedForFilter(array $data): Builder
    {
        return Abuse::query()
            ->filter(app()->make(AllAbuseFilter::class, ['queryParams' => array_filter($data)]))
            ->orderBy('updated_at', 'DESC');
    }
}
