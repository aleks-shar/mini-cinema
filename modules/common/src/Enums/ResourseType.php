<?php

declare(strict_types=1);

namespace App\Admin\Common\Enums;

use App\Api\Traits\EnumValues;

enum ResourseType: string
{
    use EnumValues;

    case MOVIE  = 'movie';
    case SERIES = 'series';
    case SEASON = 'season';
    case EPISODE = 'episode';
}
