<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Requests\Seo;

use Illuminate\Foundation\Http\FormRequest;

final class UriAndTitleRequest extends FormRequest
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
            'uri' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
        ];
    }
}
