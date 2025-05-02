<?php

declare(strict_types=1);

namespace App\Admin\Seo\Actions\SeoCommon;

use App\Admin\Seo\Repositories\SeoRepository;
use App\Api\Models\Seo;

final class UpdateAction extends BaseAction
{
    /**
     * @param array<string, mixed> $data
     */
    public function handle(array $data, int $seoId): Seo|null
    {
        $seo = $this->findTag($seoId);

        if (! $seo instanceof Seo) {
            return null;
        }

        $result = (new SeoRepository())->updateSeo($seo, $data);

        if (! $result instanceof Seo) {
            return null;
        }

        return $result;
    }
}
