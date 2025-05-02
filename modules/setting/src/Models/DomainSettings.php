<?php

declare(strict_types=1);

namespace App\Admin\Setting\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $key
 * @property string $value
 * @property ?string $description
 * @property ?string $email_update
 * @property ?Carbon $bloked_at
 */
class DomainSettings extends Model
{
    protected $table = 'domain_settings';

    protected $guarded = [];
}
