<?php

declare(strict_types=1);

namespace App\Admin\Common\Enums;

use App\Api\Traits\EnumValues;

enum RoleType: string
{
    use EnumValues;

    case ADMIN  = 'admin';
    case SEO = 'seo';
}
