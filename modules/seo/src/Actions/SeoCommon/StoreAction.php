<?php

declare(strict_types=1);

namespace App\Admin\Seo\Actions\SeoCommon;

use App\Admin\Seo\Repositories\SeoRepository;
use App\Api\Models\Seo;

final class StoreAction extends BaseAction
{
    /**
     * @param array<array-key, mixed> $data
     */
    public function handle(array $data): Seo|null
    {
        $result = (new SeoRepository())->storeSeo($data);

        if (! $result instanceof Seo) {
            return null;
        }

        return $result;
    }
}
