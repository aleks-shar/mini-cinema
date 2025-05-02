<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Requests\Seo;

use Illuminate\Foundation\Http\FormRequest;

final class HistoryDomainSeoRequest extends FormRequest
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
            'domain_id' => ['nullable', 'integer'],
            'type' => ['nullable', 'string'],
            'title' => ['nullable', 'string'],
            'action' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'daterange' => ['nullable', 'string'],
        ];
    }
}
