<?php

declare(strict_types=1);

namespace App\Admin\Seo\Repositories;

use App\Admin\Models\User;
use App\Admin\Common\Repositories\BaseRepository;
use App\Admin\Common\Models\HistoryCommonTag;
use App\Admin\Seo\Enums\OperationType;
use App\Api\Models\Seo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

final class SeoRepository extends BaseRepository
{
    public function getAllSeo(): ?Collection
    {
        return Seo::query()->orderBy('updated_at', 'DESC')->get();
    }

    public function getSeoBySeoId(int $seoId): ?Model
    {
        return  Seo::query()->where(['id' => $seoId])->first();
    }

    /**
     * @param array<string, mixed> $data
     */
    public function updateSeo(Seo $seo, array $data): Seo|false
    {
        /** @var User $user */
        $user = auth()->guard('admin')->user();

        if (! $user instanceof User) {
            return false;
        }

        $oldSeo = clone $seo;
        $seo->h1 = $data['h1'];
        $seo->title = $data['title'];
        $seo->description = $data['description'];
        $seo->keywords = $data['keywords'];
        $seo->email = $user->email;
        $seo->updated_at = now();

        if (! $seo->save()) {
            return false;
        }

        HistoryCommonTag::query()->create([
            'operation' => OperationType::UPDATE,
            'tag_id' => $seo->id,
            'alias' => $seo->alias,
            'old_h1' => $oldSeo->h1,
            'old_title' => $oldSeo->title,
            'old_description' => $oldSeo->description,
            'old_keywords' => $oldSeo->keywords,
            'new_h1' => $seo->h1,
            'new_title' => $seo->title,
            'new_description' => $seo->description,
            'new_keywords' => $seo->keywords,
            'email' => $user->email,
        ]);

        return $seo;
    }

    /**
     * @param array<array-key, mixed> $data
     */
    public function storeSeo(array $data): Model|false
    {
        /** @var User $user */
        $user = auth()->guard('admin')->user();

        if (! $user instanceof User) {
            return false;
        }

        $seo = Seo::query()->create([
            'alias' => $data['alias'],
            'controller' => $data['alias'] . '_controller',
            'action' => $data['alias'] . '_action',
            'h1' => $data['h1'] ?? null,
            'title' => $data['title'],
            'description' => $data['description'],
            'keywords' => $data['keywords'] ?? null,
            'email' => $user->email,

        ]);

        if (! $seo->save()) {
            return false;
        }

        if (! $seo instanceof Seo) {
            return false;
        }

        HistoryCommonTag::query()->create([
            'operation' => OperationType::CREATE,
            'tag_id' => $seo->id,
            'alias' => $seo->alias,
            'new_h1' => $seo->h1,
            'new_title' => $seo->title,
            'new_description' => $seo->description,
            'new_keywords' => $seo->keywords,
            'email' => $user->email,
        ]);

        return $seo;
    }

    public function getSeoByAlias(string $alias): ?Model
    {
        return Seo::query()->where(['alias' => $alias])->first();
    }
}
