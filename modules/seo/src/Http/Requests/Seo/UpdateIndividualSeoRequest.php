<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Requests\Seo;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateIndividualSeoRequest extends FormRequest
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
            'h1' => ['nullable', 'string'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'keywords' => ['nullable', 'string'],
        ];
    }
}
