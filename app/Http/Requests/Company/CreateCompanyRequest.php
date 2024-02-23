<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
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
            'address' => ['required'],
            'contact_name' => ['required'],
            'contact_mobile' => ['required','unique:contacts,mobile'],
            'contact_email' => ['required','email','unique:contacts,email']
        ];
    }
}
