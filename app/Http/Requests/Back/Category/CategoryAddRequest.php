<?php

namespace App\Http\Requests\Back\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryAddRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category_code' => ['nullable', 'string', 'max:50', Rule::unique('categories', 'category_code')],
            'description' => ['nullable', 'string'],
            'is_enabled' => ['sometimes', 'boolean'],
            'sort_order' => ['sometimes', 'integer'],
        ];
    }

    /**
     * Custom messages for validation failures.
     */
    public function messages(): array
    {
        return [
            'name.required' => '請輸入類別名稱。',
            'name.max' => '類別名稱不能超過255個字元。',

            'category_code.max' => '類別代碼不能超過50個字元。',
            'category_code.unique' => '類別代碼已存在。',

            'description.string' => '描述必須為文字。',

            'is_enabled.boolean' => '啟用欄位必須為布林值。',
            'sort_order.integer' => '排序必須為整數。',
        ];
    }
}
