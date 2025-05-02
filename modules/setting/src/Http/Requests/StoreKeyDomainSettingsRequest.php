<?php

declare(strict_types=1);

namespace App\Admin\Setting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreKeyDomainSettingsRequest extends FormRequest
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
            'key' => ['required', 'string'],
            'file_key' => ['required'],
        ];
    }
}
