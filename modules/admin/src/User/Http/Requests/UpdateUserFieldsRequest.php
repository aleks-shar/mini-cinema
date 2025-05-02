<?php

declare(strict_types=1);

namespace App\Admin\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateUserFieldsRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'string', 'max:255'],
        ];
    }
}
