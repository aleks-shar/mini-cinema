<?php

declare(strict_types=1);

namespace App\Admin\Seo\Repositories;

use App\Admin\Common\Enums\ResourseType;
use App\Admin\Common\Facades\AppView;
use App\Admin\Common\Repositories\BaseRepository;
use App\Admin\Common\Models\HistoryIndividualTag;
use App\Admin\Seo\Http\Filters\ListDomainIndividualSeoFilter;
use App\Admin\Seo\Models\MetaTag;
use App\Api\Models\Season;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

final class MetaTagRepository extends BaseRepository
{
    public function getAll(): ?LengthAwarePaginator
    {
        $result = MetaTag::query()->orderBy('updated_at', 'DESC')->paginate(self::PAGINATION);

        if (! $result instanceof LengthAwarePaginator) {
            return null;
        }

        return $result;
    }

    /**
     * @param array<array-key, mixed> $validated
     * @throws BindingResolutionException
     */
    public function getAllForFilter(array $validated): ?LengthAwarePaginator
    {
        $result = MetaTag::query()->filter(app()->make(ListDomainIndividualSeoFilter::class, ['queryParams' => array_filter($validated)]))->orderBy('updated_at', 'DESC')->paginate(self::PAGINATION);

        if (! $result instanceof LengthAwarePaginator) {
            return null;
        }

        return $result;
    }

    public function getMetaTagById(int $id, string $category): ?Model
    {
        return MetaTag::query()->where(['entity_id' => $id, 'entity_type' => $category])->first();
    }

    public function destroy(MetaTag $tag): bool
    {
        $old = clone $tag;

        if (! $tag->delete()) {
            return false;
        }

        $season = null;
        $episode = null;

        if ($old['entity_type'] === ResourseType::SEASON->value && is_int($old['entity_id'])) {
            /** @var Season $season */
            $season = AppView::getSeason($old['entity_id'], ResourseType::SEASON->value);
        }

        if ($old['entity_type'] === ResourseType::EPISODE->value && is_int($old['entity_id'])) {
            $season = AppView::getSeasonIdForEpisode($old['entity_id'], ResourseType::EPISODE->value);

            $episode = AppView::getEpisode($old['entity_id'], ResourseType::EPISODE->value);
        }

        $name = null;

        if (is_int($old['entity_id']) && is_string($old['entity_type'])) {
            $name = AppView::getTitle($old['entity_id'], $old['entity_type']);
        }

        HistoryIndividualTag::query()->create([
            'action' => 'delete',
            'name' => $name,
            'type' => $old['entity_type'],
            'email' => auth()->guard('admin')->user()->email ?? null,
            'season' => $season ?? null,
            'episode' => $episode ?? null,
            'status' => true,
            'h1' => $old['h1'],
            'title' => $old['title'],
            'description' => $old['description'],
            'keywords' => $old['keywords'],
        ]);

        return true;
    }

    public function templateStore(MetaTag $tag): bool
    {
        $tag->active = false;
        $tag->email = auth()->guard('admin')->user()->email ?? null;

        if (! $tag->save()) {
            return false;
        }

        HistoryIndividualTag::query()->where('id', $tag->id)->update(['status' => false, 'email' => auth()->guard('admin')->user()->email ?? null]);

        return true;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function individualStore(array $data): bool
    {
        $new = MetaTag::query()->create([
            'email' => $data['email'],
            'entity_id' => $data['id'],
            'entity_type' => $data['category'],
            'h1' => $data['h1'] ?? null,
            'title' => $data['title'],
            'keywords' => $data['keywords'] ?? null,
            'description' => $data['description'],
            'name' => $data['name'],
            'uri' => $data['uri'],

        ]);

        if (! $new instanceof MetaTag) {
            return false;
        }

        $name = null;

        if (is_int($data['id']) && is_string($data['category'])) {
            /** @var ?string $name */
            $name = AppView::getTitle($data['id'], $data['category']);
        }

        HistoryIndividualTag::query()->create([
            'action' => 'create',
            'name' => $name,
            'type' => $data['category'],
            'season' => $data['season'] ?? null,
            'episode' => $data['episode'] ?? null,
            'email' => $data['email'],
            'status' => true,
            'h1' => $data['h1'] ?? null,
            'title' => $data['title'],
            'description' => $data['description'],
            'keywords' => $data['keywords'] ?? null,
        ]);

        return true;
    }

    /**
     * @param array<string, string> $data
     */
    public function individualUpdate(MetaTag $tag, array $data): bool
    {
        $tag->title = $data['title'];
        $tag->description = $data['description'];
        $tag->h1 = $data['h1'] ?? null;
        $tag->active = true;
        $tag->name = $data['name'];
        $tag->uri = $data['uri'];
        $tag->email = $data['email'];
        $tag->keywords = $data['keywords'] ?? null;

        if (! $tag->save()) {
            return false;
        }

        HistoryIndividualTag::query()->create([
            'action' => 'update',
            'name' => AppView::getTitle((int)$data['id'], $data['category']),
            'type' => $data['category'],
            'email' => auth()->guard('admin')->user()->email ?? null,
            'season' => $data['season'] ?? null,
            'episode' => $data['episode'] ?? null,
            'status' => true,
            'h1' => $data['h1'] ?? null,
            'title' => $data['title'],
            'description' => $data['description'],
            'keywords' => $data['keywords'] ?? null,
        ]);

        return true;
    }
}
