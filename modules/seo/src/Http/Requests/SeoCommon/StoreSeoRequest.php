<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Requests\SeoCommon;

use Illuminate\Foundation\Http\FormRequest;

final class StoreSeoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * @return array<array-key, mixed>
     */
    public function rules(): array
    {
        return [
            'alias' => ['required', 'string'],
            'h1' => ['string', 'nullable'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'keywords' => ['string', 'nullable'],
        ];
    }
}
