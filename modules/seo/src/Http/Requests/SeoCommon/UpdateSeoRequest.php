<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Requests\SeoCommon;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateSeoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'h1' => ['string', 'nullable'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'keywords' => ['string', 'nullable'],
        ];
    }
}
