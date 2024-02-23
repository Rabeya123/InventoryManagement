<?php

namespace App\Jobs\Inventory;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Inventory;
use App\Models\InventoryIdentifier;
use App\Models\ProductIdentifier;
use App\Traits\Inventory as TraitsInventory;

class CreateTransfarIventory implements ShouldQueue
{
    use Dispatchable, TraitsInventory;

    protected $request;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function handle()
    {
        $this->Model = Inventory::create([
            'date' => $this->request['date'] ,
            'code' => $this->getCodeNumber(),
            'type' => 'transfar',
            'description' => $this->request['description'],
            'status' => 'approved',
        ]);

        $ProductItems = [];
        foreach($this->request['items'] as $key => $item){
            $match_key = array_filter($ProductItems, function($item_exits) use($item) {
                if($item_exits['product_id']  == $item['product_id']){
                    return $item_exits;
                };
            });
            if(!$match_key) {
                $A['product_id'] =  $this->request['items'][$key]['product_id'];
                $A['identifier_id'][] =  $item['identifier_id'];
                array_push($ProductItems, $A);
            }else{
                foreach($ProductItems as $key => $selected_item) {
                    if($selected_item['product_id']  == $item['product_id']){
                        $ProductItems[$key]['identifier_id'][] =  $item['identifier_id'];
                        break;
                    };
                }
            }
        }

        foreach($ProductItems as $ProductItem) {

            $product_id = $ProductItem['product_id'] ;
            $quantity = count($ProductItem['identifier_id']);

            //Update identifier location
            foreach($ProductItem['identifier_id'] as $identifier_id) {// dd($identifier_id);
                ProductIdentifier::where('id', $identifier_id)
                    ->update(['location_id' => $this->request['to_location_id']]);

                InventoryIdentifier::create([
                    'referenceable_type' => get_class($this->Model),
                    'referenceable_id' => $this->Model->id,
                    'identifier_id' => $identifier_id
                ]);

            }

            // // dd($ProductItem['identifier_id']);

            // dispatch(new CreateLocationProductStock([
            //     'is_addtion' => false,
            //     'location_id' => $this->request['from_location_id'],
            //     'product_id' =>  $product_id,
            //     'quantity' =>  $quantity,
            // ]));

            dispatch(new CreateInventoryHistory([
                'date' => $this->request['date'],
                'referenceable_type' => get_class($this->Model),
                'referenceable_id' => $this->Model->id,
                'product_id' =>  $product_id,
                'type' => 2,
                'location_id' => $this->request['from_location_id'],
                'quantity' =>  $quantity
            ]));

            dispatch(new CreateInventoryHistory([
                'date' => $this->request['date'],
                'referenceable_type' => get_class($this->Model),
                'referenceable_id' => $this->Model->id,
                'product_id' =>  $product_id,
                'type' => 1,
                'location_id' => $this->request['to_location_id'],
                'quantity' =>  $quantity
            ]));

        }
        return $this->Model;
    }
}
