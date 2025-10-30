<?php

namespace App\Http\Requests\Back\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // adjust authorization as needed
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('id');

        $alldata = $this->all();
        if (isset($alldata['set']['group_number']) && $alldata['set']['group_number'] == 1) {
            $rules['set.group_name.0'] = ['required', 'string', 'max:255'];
        }
        if (isset($alldata['set']['group_number']) && $alldata['set']['group_number'] == 2) {
            $rules['set.group_name.0'] = ['required', 'string', 'max:255'];
            $rules['set.group_name.1'] = ['required', 'string', 'max:255'];
        }

        $rules = [
            'product.name' => ['required', 'string', 'max:255'],
            'product.product_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('products', 'product_code')->ignore($productId),
            ],
            'product.description' => ['nullable', 'string'],
            'product.price' => ['nullable', 'numeric', 'min:0'],
            'product.sort_order' => ['sometimes', 'integer'],
            'is_enabled' => ['sometimes', 'boolean'],
            'is_hidden' => ['sometimes', 'boolean'],
            'hidden_at' => ['nullable', 'date'],
            'categories' => ['sometimes', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
            'images' => ['required', 'array', 'size:12'],
            'images.*' => ['nullable', 'string'],
            'set.group_number' => ['required', 'integer', 'min:1'],
            'set.sets' => ['required', 'array'],
            'set.sets.*.data' => ['required'],
            'set.sets.*.price' => ['required', 'integer', 'min:0'],
            'set.set_material' => ['required', 'array'],
            'set.set_material.*.data' => ['required', 'integer', 'exists:materials,id'],
        ];

        return $rules;
    }

    /**
     * Custom messages for validation failures.
     */
    public function messages(): array
    {
        return [
            'product.name.required' => '請輸入產品名稱。',
            'product.name.max' => '產品名稱不能超過255個字元。',

            'product.product_code.max' => '產品代碼不能超過50個字元。',
            'product.product_code.unique' => '產品代碼已被其他產品使用。',

            'product.description.string' => '描述必須為文字。',

            'product.price.numeric' => '價格必須為數字。',
            'product.price.min' => '價格不得為負數。',

            'is_enabled.boolean' => '啟用欄位必須為布林值。',
            'is_hidden.boolean' => '隱藏欄位必須為布林值。',
            'hidden_at.date' => '隱藏時間必須是有效的日期格式。',

            'product.sort_order.integer' => '排序必須為整數。',

            'images.required' => '請提供圖片陣列。',
            'images.size' => '圖片欄位數量必須為12個位置。',
            'images.*.string' => '每個圖片欄位必須為字串或為空。',

            'categories.array' => '類別必須為陣列。',
            'categories.*.integer' => '類別 ID 必須為整數。',
            'categories.*.exists' => '所選類別不存在。',

            'set.group_number.required' => '請輸入組合數量。',
            'set.group_number.integer' => '組合數量必須為整數。',
            'set.group_number.min' => '組合數量至少為1。',
            'set.group_name.*.required' => '請輸入組合名稱。',
            'set.sets.required' => '請輸入組合內容。',
            'set.sets.array' => '組合內容必須為陣列。',
            'set.sets.*.data.required' => '請輸入組合資料。',
            'set.sets.*.price.required' => '請輸入組合價格。',
            'set.sets.*.price.integer' => '組合價格必須為整數。',
            'set.sets.*.price.min' => '組合價格不得為負數。',
            'set.set_material.required' => '請輸入組合材料。',
            'set.set_material.array' => '組合材料必須為陣列。',
            'set.set_material.*.data.integer' => '組合材料 ID 必須為整數。',
            'set.set_material.*.data.exists' => '所選組合材料不存在。',
            'set.set_material.*.data.required' => '請輸入組合材料。',
            'images' => '請至少上傳一張圖片。',
        ];
    }

    /**
     * Ensure at least one image slot has non-empty data.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $images = $this->all()['images'] ?? [];
            if (!is_array($images) || count($images) === 0) {
                return;
            }
            $hasNonEmpty = false;
            foreach ($images as $img) {
                if (!is_null($img) && trim((string) $img) !== '') {
                    $hasNonEmpty = true;
                    break;
                }
            }
            if (!$hasNonEmpty) {
                $validator->errors()->add('images', '請至少上傳一張圖片。');
            }
        });
    }
}
