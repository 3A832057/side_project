<?php

namespace App\Http\Requests\Back\Material;

use Illuminate\Foundation\Http\FormRequest;

class MaterialQuantityUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'material_id' => ['required', 'integer', 'exists:materials,id'],
            'description' => ['nullable', 'string'],
            'before' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'after' => ['required', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'material_id.required' => '缺少材料 ID。',
            'material_id.integer' => '材料 ID 必須為整數。',
            'material_id.exists' => '所選材料不存在。',

            'description.string' => '描述必須為文字。',

            'before.required' => '請提供原始數量（before）。',
            'before.numeric' => '原始數量必須為數字。',

            'quantity.required' => '請輸入異動數量。',
            'quantity.numeric' => '異動數量必須為數字。',

            'after.required' => '請提供變動後數量（after）。',
            'after.numeric' => '變動後數量必須為數字。',
        ];
    }
}
