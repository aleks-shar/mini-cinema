<?php

declare(strict_types=1);

namespace App\Api\Http\Resources;

use App\Api\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Movie $resource
 */
final class MovieResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Movie $this */
        return [
            'slug' => $this->slug,
            'title' => ! empty($this->title) ? $this->title : $this->title_original,
            'title_original' => $this->title_original,
            'description' => $this->description,
            'age_limit' => $this->age_limit,
            'year' => $this->year,
            'duration' => $this->duration,
            'directors' => $this->directors,
            'writers' => $this->writers,
            'release_date' => $this->release_date,
        ];
    }
}
