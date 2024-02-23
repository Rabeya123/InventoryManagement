<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class InventoryRequest extends FormRequest
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
        if(request('type_id') == 3) {
            return [
                'date' => ['required','date'],
                'to_location_id' => ['required'],
                'from_location_id' => ['required_if:type_id,3', 'prohibited_if:to_location_id,' . request('from_location_id')],
                'description' => ['nullable'],
                'type_id' => ['required'],
                'items.*' => ['required'],
            ];
        }else{
            return [
                'date' => ['required','date'],
                'from_location_id' => ['required'],
                'to_location_id' => ['required_if:type_id,3'],
                'description' => ['nullable'],
                'purchase_order_id' => ['required_if:type_id,1'],
                'type_id' => ['required'],
                'product_id.*' => ['required'],
                'identifier.*' => ['nullable'],
                'quantity.*' => ['required']
            ];
        }
    }
}
