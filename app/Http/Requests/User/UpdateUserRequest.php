<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required','unique:users,email,' . $this->user],
            'role_id' => ['required'],
            'mobile' => ['nullable'],
            'is_active' => ['required'],
        ];
    }
}
