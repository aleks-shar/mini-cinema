<?php

declare(strict_types=1);

namespace App\Admin\Common\Models;

use App\Admin\Common\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * @method filter()
 */
final class HistoryIndividualTag extends Model
{
    use Filterable;

    protected $table = 'history_individual_tags';
    protected $guarded = [];
}
