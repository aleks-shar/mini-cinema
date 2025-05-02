<?php

declare(strict_types=1);

namespace App\Admin\Seo\Models;

use App\Admin\Common\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $entity_id
 * @property int|null $domain_id
 * @property string $entity_type
 * @property bool|null $active
 * @property string|null $h1
 * @property string $title
 * @property string|null $season
 * @property string|null $episode
 * @property string|null $uri
 * @property string $description
 * @property string|null $keywords
 * @property string|null $name
 * @property string|null $email
 * @property string|null $image
 * @property string|null $text
 * @property string|null $og_title
 * @property string|null $og_description
 */
final class MetaTag extends Model
{
    use Filterable;

    protected $table = 'meta_tags';
    protected $guarded = [];
}
