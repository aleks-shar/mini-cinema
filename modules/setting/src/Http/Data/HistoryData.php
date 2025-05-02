<?php

declare(strict_types=1);

namespace App\Admin\Setting\Http\Data;

use Spatie\LaravelData\Data;

/**
 * @property ?string $action
 * @property ?string $email
 * @property ?string $daterange
 */
class HistoryData extends Data
{
    public function __construct(
        public ?string $action,
        public ?string $email,
        public ?string $daterange,
    ) {
    }
}
