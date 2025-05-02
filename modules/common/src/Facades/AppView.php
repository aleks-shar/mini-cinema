<?php

declare(strict_types=1);

namespace App\Admin\Common\Facades;

use App\Admin\Common\Facades\Implementations\ViewFacade;
use Illuminate\Support\Facades\Facade;

/**
 * @method static int|null getSeason(int $id, string $category)
 * @method static string|null getTitle(int $id, string $category)
 * @method static string|null getSeriesTitleForEpisode(int $id)
 * @method static int|null getSeasonIdForEpisode(int $id, string $category = null)
 * @method static int|null getEpisode(int $id, string $category)
 * @method static mixed getModel(int $id, string $category)
 * @method static string getUserNameByEmail(string $email)
 * @method static string getUserNameById(int $id)
 * @method static string getUserEmailById(int $id)
 */
class AppView extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return ViewFacade::class;
    }
}
