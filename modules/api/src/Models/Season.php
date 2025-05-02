<?php

declare(strict_types=1);

namespace App\Api\Models;

use App\Admin\Common\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $is_abuse
 * @property int $part
 * @property int $parts
 * @property int $series_id
 * @property string $slug
 * @property string $title
 * @method filter()
 */
class Season extends Model
{
    use Filterable;

    protected $table = 'seasons';

    protected array $dates = [
        'created_at',
        'updated_at',
        'release_date',
    ];

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class)->with(['seasons']);
    }

    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class)->orderBy('part');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
