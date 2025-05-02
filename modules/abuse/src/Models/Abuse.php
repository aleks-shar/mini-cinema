<?php

declare(strict_types=1);

namespace App\Admin\Abuse\Models;

use App\Admin\Common\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $model_id
 * @property string $category
 * @property int $is_abuse
 * @property string $email
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method filter()
 */
final class Abuse extends Model
{
    use Filterable;

    protected $table = 'abused';
    protected $guarded = [];
}
