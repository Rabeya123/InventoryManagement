<?php

namespace App\Jobs\Inventory;

use App\Models\ProductLocation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateLocationProductStock implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request; 

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function handle()
    {
        $ProductStock = ProductLocation::where([ 'location_id' => $this->request['location_id'], 'location_id' => $this->request['product_id'] ])
            ->first();
        $LastStockQuantity = $ProductStock ?  $ProductStock->quantity : 0;

        if($this->request['is_addtion']) {
            ProductLocation::create([
                'location_id' => $this->request['location_id'],
                'product_id' =>  $this->request['product_id'],
                'quantity' =>  $LastStockQuantity + $this->request['quantity'],
            ]);
        }else{
            ProductLocation::create([
                'location_id' => $this->request['location_id'],
                'product_id' =>  $this->request['product_id'],
                'quantity' =>  $LastStockQuantity - $this->request['quantity'],
            ]);
        }
    }
}
