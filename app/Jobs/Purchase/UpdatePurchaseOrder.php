<?php

namespace App\Jobs\Purchase;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class UpdatePurchaseOrder
{
    use Dispatchable;

    protected $request;
    protected $model;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($model, array $request)
    {
        $this->model = $model; 
        $this->request = $request; 
    }

    public function handle()
    {
        DB::beginTransaction();
            
            $this->model->load('orders', 'conditions', 'contact', 'shipping_address');
            
            if($this->request['status'] == 'approved') {
                $this->request['approved_by'] = auth()->id();
              //  $this->model->update($this->request);
            }
            
            // else{
            //     unset($this->request['status']);
            //     $this->model->update($this->request);
            // }
            $this->model->update($this->request);
            $this->model->refresh();
            $total_addtional_charge = $this->model->service_charge + $this->model->others_charge;

            if($total_addtional_charge > 0) {
                $addtional_price_each_product = ($total_addtional_charge / array_sum($this->request['quantity']));
            }else{
                $addtional_price_each_product = 0;
            }
        //    dd($addtional_price_each_product);
            //add product details
            $this->model->orders()->delete();
            if(isset($this->request['product_id'])){
                for ($i=0; $i < count($this->request['product_id']) ; $i++) { 

                    if($this->request['tax_percentile'][$i] > 0){
                        $tax_amount = $this->request['purchase_price'][$i] / 100 * $this->request['tax_percentile'][$i];
                    }else{
                        $tax_amount = 0;
                    }

                    $total_average_product_price = $addtional_price_each_product + $tax_amount + $this->request['purchase_price'][$i]; 

                    dispatch(new CreatePurchaseOrderProduct([
                        'purchase_order_id' => $this->model->id,
                        'product_id' =>  $this->request['product_id'][$i],
                        'purchase_price' =>  $this->request['purchase_price'][$i],
                        'purchase_price_avg' =>  $total_average_product_price ,
                        'quantity' =>  $this->request['quantity'][$i],
                        'tax_percentile' =>  $this->request['tax_percentile'][$i],
                    ])); 
                }
            }

            $this->model->conditions()->delete();
            if(isset($this->request['purchase_order_condition'])) {
                for ($i=0; $i < count($this->request['purchase_order_condition']) ; $i++) { 
                    dispatch(new CreatePurchaseOrderCondition([
                        'purchase_order_id' => $this->model->id,
                        'name' =>  $this->request['purchase_order_condition'][$i],
                    ])); 
                }
            }

            if($this->request['shipping_address']) {
                // store shipping address
                $this->model->shipping_address()->delete();
                $ShippingAddress = dispatch_sync(new CreateShippingAddress([
                    'details' => $this->request['shipping_address']
                ]));

                if($ShippingAddress)$this->model->update(['shipping_address_id' => $ShippingAddress->id]);
            }
            
        DB::commit();
        return $this->model;
    }
}
