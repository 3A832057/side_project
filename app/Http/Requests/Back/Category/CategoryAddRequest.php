<?php

namespace App\Http\Requests\Back\Category;

use Illuminate\Foundation\Http\FormRequest;

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
         $rules  = [];

         if(($this->all())['level'] > 1) {
               $rules['parent_id'] = ['required', 'integer', 'exists:categories,id'];
         }

         $rules['level'] = ['required', 'integer', 'min:1'];
         $rules['name'] = ['required', 'string', 'max:255'];
         $rules['description'] = ['nullable', 'string'];
         $rules['is_enabled'] = ['sometimes', 'boolean'];
         $rules['sort_order'] = ['sometimes', 'integer'];

         return $rules;
    }

    /**
     * Custom messages for validation failures.
     */
    public function messages(): array
    {
        return [
            'parent_id.required' => '請選擇父類別。',
            'parent_id.integer' => '父類別必須為整數。',
            'parent_id.exists' => '所選擇的父類別不存在。',

            'level.required' => '請選擇類別層級。',
            'level.integer' => '類別層級必須為整數。',
            'level.min' => '類別層級必須至少為1。',
            
            
            'name.required' => '請輸入類別名稱。',
            'name.max' => '類別名稱不能超過255個字元。',

            'description.string' => '描述必須為文字。',

            'is_enabled.boolean' => '啟用欄位必須為布林值。',
            'sort_order.integer' => '排序必須為整數。',
        ];
    }
}
