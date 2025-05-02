<?php

declare(strict_types=1);

namespace App\Api\Models;

use App\Admin\Common\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int $part
 * @property int $is_abuse
 * @property int $series_id
 * @property int $season_id
 * @property string $slug
 * @property string $title
 * @method filter()
 */
class Episode extends Model
{
    use Filterable;

    protected $table = 'episodes';

    protected array $dates = [
        'created_at',
        'updated_at',
        'release_date',
    ];

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class)->with(['seasons']);
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
