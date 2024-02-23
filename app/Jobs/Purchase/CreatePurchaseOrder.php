<?php

namespace App\Jobs\Purchase;

use App\Models\PurchaseOrder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class CreatePurchaseOrder
{
    use Dispatchable;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $request)
    {
        $this->request = $request; 
    }

    public function handle()
    {
        DB::beginTransaction();

            $PurchaseOrder = PurchaseOrder::create($this->request);
        
            //add product details
            for ($i=0; $i < count($this->request['product_id']) ; $i++) { 
                dispatch(new CreatePurchaseOrderProduct([
                    'purchase_order_id' => $PurchaseOrder->id,
                    'product_id' =>  $this->request['product_id'][$i],
                    'purchase_price' =>  $this->request['purchase_price'][$i],
                    'quantity' =>  $this->request['quantity'][$i],
                    'tax_percentile' =>  $this->request['tax_percentile'][$i],
                ])); 
            }

            if(isset($this->request['purchase_order_condition'])){
                for ($i=0; $i < count($this->request['purchase_order_condition']) ; $i++) { 
                    dispatch(new CreatePurchaseOrderCondition([
                        'purchase_order_id' => $PurchaseOrder->id,
                        'name' =>  $this->request['purchase_order_condition'][$i],
                    ])); 
                }
            }

            if($this->request['shipping_address']){
                // store shipping address
                $ShippingAddress = dispatch_sync(new CreateShippingAddress([
                    'details' => $this->request['shipping_address']
                ]));

                if($ShippingAddress)$PurchaseOrder->update(['shipping_address_id' => $ShippingAddress->id]);
            }
        DB::commit();
    }
}
