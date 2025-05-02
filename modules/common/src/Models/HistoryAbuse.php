<?php

declare(strict_types=1);

namespace App\Admin\Common\Models;

use App\Admin\Common\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * @method filter()
 */
final class HistoryAbuse extends Model
{
    use Filterable;

    protected $table = 'history_abuse';
    protected $guarded = [];
}
