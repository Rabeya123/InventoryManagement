<?php

namespace App\Http\Requests\Requisition;

use Illuminate\Foundation\Http\FormRequest;

class RequisitionRequest extends FormRequest
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
        if($this->is_approved) {
            return [
                'location_id' => ['required'],
                'contact_id' => ['nullable'],
                'delivery_address' => ['nullable'],
                'delivery_date' => ['nullable','date'],
                'location_id' => ['nullable'],
                'req_product_id.*' => ['required'],
                'product_id.*' => ['required'],
                'quantity.*' => ['required'],
                'approved_quantity.*' => ['required'],
                'identifier_id.*' => ['required'],
                'identifier_product_id.*' => ['required']
            ];
        }else{
            return [
                'date' => ['required','date'],
                'contact_id' => ['nullable'],
                'location_id' => ['nullable'],
                'user_id' => ['required'],
                'description' => ['nullable'],
                'delivery_address' => ['nullable'],
                'delivery_date' => ['nullable','date'],
                'product_id.*' => ['required'],
                'quantity.*' => ['required']
            ];
        }
    }
}
