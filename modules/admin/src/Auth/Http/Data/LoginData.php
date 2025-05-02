<?php

declare(strict_types=1);

namespace App\Admin\Auth\Http\Data;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Data;

/**
 * @property string $email
 * @property string $password
 */
class LoginData extends Data
{
    public function __construct(
        #[Email]
        public string $email,
        public string $password,
    ) {
    }
}
