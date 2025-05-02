<?php

declare(strict_types=1);

namespace App\Admin\Common\Models;

use App\Admin\Common\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * @method filter()
 */
final class HistoryCommonTag extends Model
{
    use Filterable;

    protected $table = 'history_common_tags';
    protected $guarded = [];
}
