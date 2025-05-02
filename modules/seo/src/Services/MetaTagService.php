<?php

declare(strict_types=1);

namespace App\Admin\Seo\Services;

use App\Admin\Common\Services\BaseService;
use App\Admin\Seo\Repositories\MetaTagRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

final class MetaTagService extends BaseService
{
    public function getMetaTagById(int $id, string $category): ?Model
    {
        return (new MetaTagRepository())->getMetaTagById($id, $category);
    }

    public function getAll(): ?LengthAwarePaginator
    {
        return (new MetaTagRepository())->getAll();
    }

    /**
     * @param array<array-key, mixed> $validated
     * @throws BindingResolutionException
     */
    public function getAllForFilter(array $validated): ?LengthAwarePaginator
    {
        return (new MetaTagRepository())->getAllForFilter($validated);
    }
}
