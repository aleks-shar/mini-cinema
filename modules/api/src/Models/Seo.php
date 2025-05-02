<?php

declare(strict_types=1);

namespace App\Api\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property ?string $alias
 * @property int $domain_id
 * @property ?string $image
 * @property ?string $text
 * @property ?string $h1
 * @property ?string $h2
 * @property ?string $title
 * @property ?string $keywords
 * @property ?string $description
 * @property ?string $og_title
 * @property ?string $og_description
 * @property ?string $email
 * @property string $footer
 * @property string $controller
 * @property string $action
 * @property Carbon $updated_at
 */
class Seo extends Model
{
    protected $table = 'seo';

    protected $guarded = [];

    protected array $dates = [
        'created_at',
        'updated_at',
    ];
}
