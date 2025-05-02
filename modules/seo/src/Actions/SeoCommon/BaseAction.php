<?php

declare(strict_types=1);

namespace App\Admin\Seo\Actions\SeoCommon;

use App\Admin\Seo\Repositories\SeoRepository;
use App\Api\Models\Seo;

abstract class BaseAction
{
    protected function findTag(int $seoId): Seo|null
    {
        $seo = (new SeoRepository())->getSeoBySeoId($seoId);

        if (! $seo instanceof Seo) {
            return null;
        }

        return $seo;
    }
}
