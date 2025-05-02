<?php

declare(strict_types=1);

namespace App\Admin\Seo\Actions\SeoCommon;

use App\Admin\Models\User;
use App\Admin\Common\Models\HistoryCommonTag;
use App\Admin\Seo\Enums\OperationType;
use App\Api\Models\Seo;

final class DestroyAction extends BaseAction
{
    public function handle(int $seoId): bool|null
    {
        $seo = $this->findTag($seoId);

        if (! $seo instanceof Seo) {
            return false;
        }

        /** @var User $user */
        $user = auth()->guard('admin')->user();

        if (! $user instanceof User) {
            return false;
        }

        HistoryCommonTag::query()->create([
            'operation' => OperationType::DELETE,
            'tag_id' => $seo->id,
            'alias' => $seo->alias,
            'new_h1' => '',
            'new_title' => '',
            'new_description' => '',
            'new_keywords' => '',
            'email' => $user->email,
        ]);

        return $seo->delete();
    }
}
