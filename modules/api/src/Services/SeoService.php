<?php

declare(strict_types=1);

namespace App\Api\Services;

use App\Api\Traits\SeoParams;
use App\Api\Http\Resources\SeoResource;

final class SeoService
{
    use SeoParams;

    /**
     * @param array<string, mixed> $data
     */
    public function getSeoData(array $hostSettings, array $data): SeoResource
    {

        return new SeoResource(MetaTagsService::getSeoData($hostSettings, $data));
    }

    public function getSeoDataByAlias(array $hostSettings, string $alias, array $data): SeoResource
    {
        return new SeoResource(MetaTagsService::getSeoDataByAlias(
            $hostSettings['pattern'],
            $hostSettings['page'],
            $alias,
            $data
        ));
    }
}
