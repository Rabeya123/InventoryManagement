<?php

namespace App\Jobs\Requisition;

use App\Jobs\Floating\CreateUserProduct;
use App\Jobs\Inventory\CreateInventoryHistory;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Jobs\Inventory\CreateLocationProductStock;
use App\Models\Inventory;
use App\Models\ProductIdentifier;
use App\Models\ProductLocation;
use App\Models\RequisitionProduct;
use App\Models\UserProduct;
use App\Traits\Inventory as TraitsInventory;

class ApprovedRequisition implements ShouldQueue
{
    use Dispatchable, TraitsInventory;

    protected $request;
    protected $Model;

    public function __construct(array $request, $Model)
    {
        $this->request = $request;
        $this->Model = $Model;
    }

    public function handle()
    { //dd($this->request);
        DB::beginTransaction();

            if(isset($this->request['identifier_id'])) {
                ProductIdentifier::whereIn('id', $this->request['identifier_id'])
                    ->update([
                        'float_user_id' => $this->Model['requisition_for_user_id'],
                        'float_user_add_at' => Carbon::now()->toDateTimeString()
                    ]);

                //assign indentifier
                foreach($this->request['identifier_id'] as $identifer_id) {
                    $RequisitionIdentifers[] = [ 'requestion_id' => $this->Model->id,'indentifier_id'  => $identifer_id ];
                }
                DB::table('requestion_product_identifer')->insert($RequisitionIdentifers);
            }

            $Inventory = Inventory::create([
                'date' => $this->Model['date'],
                'code' => $this->getCodeNumber(),
                'type' => 'deduction',
                'description' => $this->Model['description'],
                'status' => 'approved',
            ]);

            for ($i=0; $i < count($this->request['product_id']) ; $i++) {

                $product_id = $this->request['product_id'][$i];
                if(isset($this->request['identifier_id'])) {
                    $count = count(array_filter($this->request['identifier_product_id'],function($value)use($product_id){return $product_id === $value;}));
                }else{
                    $count = 0;
                }

                if($count == 0) {
                    $count = $this->request['approved_quantity'][$i];
                }

                if($count > 0){

                    dispatch( new UpdateRequisitionProduct([
                        'approved_quantity' => $count
                    ], RequisitionProduct::find($this->request['req_product_id'][$i])));

                    // dispatch(new CreateLocationProductStock([
                    //     'is_addtion' => false,
                    //     'location_id' => $this->request['location_id'],
                    //     'product_id' =>  $product_id,
                    //     'quantity' => $count,
                    // ]));

                    dispatch(new CreateInventoryHistory([
                        'date' => $this->Model['date'],
                        'inventory_id' => $Inventory['id'],
                        'referenceable_type' => get_class($this->Model),
                        'referenceable_id' => $this->Model->id,
                        'product_id' =>  $product_id,
                        'type' => 2, // proudct out
                        'location_id' => $this->request['location_id'],
                        'quantity' =>  $count
                    ]));

                    dispatch(new CreateUserProduct([
                            'user_id' => $this->Model['requisition_for_user_id'],
                            'quantity' =>  $count,
                            'product_id' =>  $product_id,
                            'consume_quantity' => 0
                    ]));
                }
            }

            $this->Model->update([
                'status' => 'approved',
                'location_id' => $this->request['location_id'],
            ]);
        DB::commit();
    }
}
