<?php

declare(strict_types=1);

namespace App\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class SeriesGetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'episode' => 'integer|min:0',
            'season' => 'integer|min:1',
        ];
    }
}
