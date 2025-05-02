<?php

declare(strict_types=1);

namespace App\Admin\Common\Repositories;

abstract class BaseRepository
{
    protected const int PAGINATION = 100;
    protected const int|float TTL = 60 * 60;
}
