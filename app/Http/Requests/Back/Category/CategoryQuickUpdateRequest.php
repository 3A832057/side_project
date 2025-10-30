<?php

namespace App\Http\Requests\Back\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryQuickUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * Used for quick/index updates (eg. toggling is_enabled)
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'is_enabled' => ['required', 'boolean'],
            'sort_order' => ['sometimes', 'integer'],
        ];
    }

    /**
     * Custom messages for validation failures.
     */
    public function messages(): array
    {
        return [
            'is_enabled.required' => '請提供啟用狀態（is_enabled）。',
            'is_enabled.boolean' => '啟用狀態必須為布林值。',
            'sort_order.integer' => '排序必須為整數。',
        ];
    }
}
