<?php

declare(strict_types=1);

namespace App\Api\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class SeoResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'title' => $this['title'],
            'keywords' => $this['keywords'],
            'description' => $this['description'],
            'h1' => $this['h1'],
        ];
    }
}
