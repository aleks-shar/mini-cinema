<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Requests\Seo;

use Illuminate\Foundation\Http\FormRequest;

final class AllDomainSeoRequest extends FormRequest
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
            'type' => ['nullable', 'string'],
            'title' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'daterange' => ['nullable', 'string'],
        ];
    }
}
