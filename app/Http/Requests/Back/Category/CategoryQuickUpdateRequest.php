<?php

namespace App\Http\Requests\Back\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class CategoryQuickUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
         $rules  = [];

         
        $categoryId = $this->route('id');

        if( !DB::table('categories')->where('id', $categoryId)->exists() ){
            $rules['id'] = ['exists:categories,id'];
        }


         if(isset($this->all()['level'])) {
             $rules['level'] = ['required', 'integer', 'min:1'];
         }

         if(isset($this->all()['name'])) {
            $rules['name'] = ['required', 'string', 'max:255'];
         }

         if(isset($this->all()['description'])) {
            $rules['description'] = ['nullable', 'string'];
         }

         if(isset($this->all()['is_enabled'])) {
            $rules['is_enabled'] = ['required', 'boolean'];
         }

        

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

            'is_enabled.required' => '請輸入狀態。',
            'is_enabled.boolean' => '啟用欄位必須為布林值。',
        ];
    }
}
