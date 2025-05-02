<?php

declare(strict_types=1);

namespace App\Admin\Seo\Actions\SeoCommon;

use App\Api\Models\Seo;

final class EditAction extends BaseAction
{
    public function handle(int $seoId): Seo|null
    {
        return $this->findTag($seoId);
    }
}
