<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'contact_mobile' => ['required','unique:contacts,mobile,' . $this->contact_id ],
            'contact_email' => ['required','email','unique:contacts,email,' . $this->contact_id]
        ];
    }
}
