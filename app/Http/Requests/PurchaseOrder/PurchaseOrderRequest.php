<?php

namespace App\Http\Requests\PurchaseOrder;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderRequest extends FormRequest
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
        if($this->method() == 'PUT') {
            return [
                'date' => ['required','date'],
                'code' => ['required', 'unique:purchase_orders,code,' .  $this->purchase_order->id ],
                'title' => ['required'],
                'contact_id' => ['required'],
                'reference_no' => ['nullable'],
                'description' => ['nullable'],
                'status' => ['nullable'],
    
                'service_charge' => ['required'],
                'others_charge' => ['required'],
    
                'product_id.*' => ['required'],
                'product_tax_amount.*' => ['required'],
                'purchase_price.*' => ['required'],
                'tax_percentile.*' => ['required'],
                'quantity.*' => ['required'],
    
                'purchase_order_condition.*' => ['nullable'],
                'shipping_address' => ['nullable'],
            ];
        }else{
            return [
                'date' => ['required','date'],
                'code' => ['required', 'unique:purchase_orders'],
                'title' => ['required'],
                'contact_id' => ['required'],
                'reference_no' => ['nullable'],
                'description' => ['nullable'],
                'status' => ['nullable'],
    
                'service_charge' => ['required'],
                'others_charge' => ['required'],
    
                'product_id.*' => ['required'],
                'product_tax_amount.*' => ['required'],
                'purchase_price.*' => ['required'],
                'tax_percentile.*' => ['required'],
                'quantity.*' => ['required'],
    
                'purchase_order_condition.*' => ['nullable'],
                'shipping_address' => ['nullable'],
            ];
        }

    }
}
