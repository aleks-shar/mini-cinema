<?php

declare(strict_types=1);

namespace App\Api\Models;

use App\Admin\Common\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $is_abuse
 * @property ?int $year
 * @property ?int $duration
 * @property ?int $age_limit
 * @property ?float $rating
 * @property string $title
 * @property ?string title_original
 * @property string $slug
 * @property string $directors
 * @property string $writers
 * @property ?string $description
 * @property ?Carbon $release_date
 * @method filter()
 */
final class Movie extends Model
{
    use Filterable;

    protected $table = 'movies';

    protected array $dates = [
        'created_at',
        'updated_at',
        'release_date',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
