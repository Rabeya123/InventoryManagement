<?php

namespace App\Jobs\Inventory;

use App\Jobs\Inventory\CreateProductBatch;
use App\Models\Inventory;
use App\Models\ProductBatch;
use App\Models\ProductIdentifier;
use App\Models\PurchaseOrder;
use App\Traits\Batch;
use App\Traits\Inventory as TraitsInventory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CreateInventory implements ShouldQueue
{
    use Dispatchable, TraitsInventory;

    protected $request;
    protected $Model;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function handle()
    {
            if(isset($this->request['purchase_order_id'])){
                $this->Model = PurchaseOrder::with('orders')
                    ->findOrFail($this->request['purchase_order_id']); //dd( $this->Model);
            }

            $Inventory = Inventory::create([
                'date' => $this->request['date'] ,
                'code' => $this->getCodeNumber(),
                'type' => 'addtion',
                'description' => $this->request['description'],
                'status' => 'approved',
            ]);

            for ($i=0; $i < count($this->request['product_id']) ; $i++) {

                $product_id = $this->request['product_id'][$i] ;
                $this->Model->orders->where('product_id', $product_id)->first();
                $PurchseProduct = $this->Model->orders->where('product_id', $product_id)->first();

                $ProductBatch = dispatch_sync(new CreateProductBatch([
                    'sourceable_type' => get_class($this->Model),
                    'sourceable_id' => $this->Model->id,
                    'product_id' =>  $product_id,
                    'location_id' => $this->request['from_location_id'],
                    'purchase_price' => $PurchseProduct->purchase_price_avg
                ]));

                if(isset($this->request['temporary_batch'][$i])) {
                    if($product_id == $this->request['temporary_batch'][$i]['product_id']){
                        $quantity = ProductIdentifier::where('product_id', $this->request['temporary_batch'][$i]['product_id'])
                            ->where('batch_id', $this->request['temporary_batch'][$i]['batch'])
                            ->update(['batch_id' => $ProductBatch->id]);
                    }else{
                        $quantity = $this->request['quantity'][$i];
                    }
                }else{
                    $quantity = $this->request['quantity'][$i];
                }

                // dispatch(new CreateLocationProductStock([
                //     'is_addtion' => false,
                //     'location_id' => $this->request['from_location_id'],
                //     'product_id' =>  $product_id,
                //     'quantity' =>  $quantity,
                // ]));

                dispatch(new CreateInventoryHistory([
                    'date' => $this->request['date'],
                    'inventory_id' => $Inventory['id'],
                    'file_url' => $this->request['file_names'][$i],
                    'referenceable_type' => get_class($this->Model),
                    'referenceable_id' => $this->Model->id,
                    'product_id' =>  $product_id,
                    'type' => $this->request['type_id'],
                    'location_id' => $this->request['from_location_id'],
                    'quantity' =>  $quantity
                ]));

            }

        return $this->Model;
    }

}
