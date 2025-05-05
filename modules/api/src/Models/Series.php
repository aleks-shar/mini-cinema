<?php

declare(strict_types=1);

namespace App\Api\Models;

use App\Admin\Common\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $is_abuse
 * @property string $title
 * @property ?string $title_original
 * @property ?string $description
 * @property string $slug
 * @property ?int $duration
 * @property ?int $age_limit
 * @property ?int $parts
 * @property ?int $year
 * @property string $directors
 * @property string $writers
 * @property Season $seasons
 * @property ?Carbon $release_date
 * @method filter()
 */
class Series extends Model
{
    use Filterable;

    protected $table = 'series';

    protected array $dates = [
        'created_at',
        'updated_at',
        'release_date',
    ];

    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class)->orderBy('part');
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
