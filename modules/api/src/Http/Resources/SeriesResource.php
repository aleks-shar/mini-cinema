<?php

declare(strict_types=1);

namespace App\Api\Http\Resources;

use App\Api\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Series $resource
 */
final class SeriesResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Series $this */
        return [
            'slug' => $this->slug,
            'title' => ! empty($this->title) ? $this->title : $this->title_original,
            'title_original' => $this->title_original,
            'description' => $this->description,
            'parts' => $this->parts,
            'age_limit' => $this->age_limit,
            'year' => $this->year,
            'duration' => $this->duration,
            'directors' => $this->directors,
            'writers' => $this->writers,
            'release_date' => $this->release_date,
        ];
    }
}
