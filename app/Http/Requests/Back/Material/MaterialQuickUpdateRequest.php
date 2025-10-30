<?php

namespace App\Http\Requests\Back\Material;

use Illuminate\Foundation\Http\FormRequest;

class MaterialQuickUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_enabled' => ['required', 'boolean'],
            'quantity' => ['sometimes', 'numeric'],
            'low_danger' => ['sometimes', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'is_enabled.required' => '請提供啟用狀態（is_enabled）。',
            'is_enabled.boolean' => '啟用狀態必須為布林值。',
            'quantity.numeric' => '數量必須為數字。',
            'low_danger.numeric' => '低限數值必須為數字。',
        ];
    }
}
