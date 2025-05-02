<?php

declare(strict_types=1);

namespace App\Admin\Seo\Enums;

use App\Api\Traits\EnumValues;

enum OperationType: string
{
    use EnumValues;

    case CREATE  = 'Create';
    case UPDATE = 'Update';
    case DELETE = 'Delete';
}
