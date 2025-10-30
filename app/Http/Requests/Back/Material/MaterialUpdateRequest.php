<?php

namespace App\Http\Requests\Back\Material;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MaterialUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $materialId = $this->route('id');

        return [
            'name' => ['required', 'string', 'max:255'],
            'material_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('materials', 'material_code')->ignore($materialId),
            ],
            'cost' => ['nullable', 'numeric', 'min:0'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'quantity' => ['sometimes', 'numeric'],
            'is_enabled' => ['sometimes', 'boolean'],
            'is_hidden' => ['sometimes', 'boolean'],
            'hidden_at' => ['nullable', 'date'],
            'low_danger' => ['sometimes', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '請輸入材料名稱。',
            'name.max' => '材料名稱不能超過255個字元。',

            'material_code.max' => '材料代碼不能超過50個字元。',
            'material_code.unique' => '材料代碼已被其他材料使用。',

            'cost.numeric' => '成本必須為數字。',
            'cost.min' => '成本不得為負數。',

            'price.numeric' => '價格必須為數字。',
            'price.min' => '價格不得為負數。',

            'quantity.numeric' => '數量必須為數字。',

            'is_enabled.boolean' => '啟用欄位必須為布林值。',
            'is_hidden.boolean' => '隱藏欄位必須為布林值。',
            'hidden_at.date' => '隱藏時間必須為有效的日期格式。',

            'low_danger.numeric' => '低限數值必須為數字。',
        ];
    }
}
