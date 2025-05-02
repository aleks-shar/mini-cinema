<?php

declare(strict_types=1);

namespace App\Admin\Abuse\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class AllAbuseRequest extends FormRequest
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
            'email' => ['nullable', 'string'],
            'type' => ['nullable', 'string'],
            'daterange' => ['nullable', 'string'],
        ];
    }
}
