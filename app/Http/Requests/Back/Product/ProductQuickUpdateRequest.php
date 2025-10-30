<?php

namespace App\Http\Requests\Back\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class ProductQuickUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [];

        $productId = $this->route('id');
        
        if( !DB::table('products')->where('id', $productId)->exists() ){
            $rules['id'] = ['exists:products,id'];
        }

        if (isset($this->all()['is_enabled'])) {
            $rules['is_enabled'] = ['required', 'boolean'];
        }

        if (isset($this->all()['is_hidden'])) {
            $rules['is_hidden'] = ['required', 'boolean'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'is_enabled.required' => '請輸入啟用狀態。',
            'is_enabled.boolean' => '啟用狀態必須為布林值。',
            'is_hidden.required' => '請輸入隱藏狀態。',
            'is_hidden.boolean' => '隱藏狀態必須為布林值。',
        ];
    }
}
