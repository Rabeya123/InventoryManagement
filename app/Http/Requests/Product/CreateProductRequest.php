<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'code' => ['required','unique:products'],
            'origin' => ['required'],
            'has_identifier' => ['required'],
            'reorder_limit' => ['nullable'],
            'description' => ['nullable'],
            'category_id' => ['required'],
            'unit_id' => ['required'],
            'is_active' => ['required'],
        ];
    }
}
