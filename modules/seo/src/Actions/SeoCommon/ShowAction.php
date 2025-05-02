<?php

declare(strict_types=1);

namespace App\Admin\Seo\Actions\SeoCommon;

use App\Admin\Seo\Repositories\SeoRepository;
use Illuminate\Database\Eloquent\Collection;

final class ShowAction extends BaseAction
{
    public function handle(): Collection|null
    {
        return (new SeoRepository())->getAllSeo();
    }
}
