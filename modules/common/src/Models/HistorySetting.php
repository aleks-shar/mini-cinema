<?php

declare(strict_types=1);

namespace App\Admin\Common\Models;

use App\Admin\Common\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $email
 * @property string $action
 * @property string $tag_id
 * @property int $domain_id
 * @property string $domain
 * @property string|null $old_key
 * @property string $new_key
 * @property string|null $old_value
 * @property string $new_value
 * @property string|null $old_description
 * @property string $new_description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method filter()
 */
final class HistorySetting extends Model
{
    use Filterable;

    protected $table = 'history_settings';
    protected $guarded = [];
}
