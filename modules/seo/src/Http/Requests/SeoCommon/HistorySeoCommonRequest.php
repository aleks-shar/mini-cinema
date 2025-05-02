<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Requests\SeoCommon;

use Illuminate\Foundation\Http\FormRequest;

final class HistorySeoCommonRequest extends FormRequest
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
            'alias' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'daterange' => ['nullable', 'string'],
        ];
    }
}
