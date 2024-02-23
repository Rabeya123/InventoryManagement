<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContctRequest extends FormRequest
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
            'company_id' => ['required'],
            'mobile' => ['required','unique:contacts,mobile,' . $this->contact->id ],
            'email' => ['required','email','unique:contacts,email,' . $this->contact->id ]
        ];
    }
}
