<?php

namespace App\Jobs\Requisition;

use App\Models\Requisition;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class UpdateRequisition
{
    use Dispatchable;
    
    protected $request; 
    protected $Model;

    public function __construct(array $request, $Model)
    {
        $this->request = $request;
        $this->Model = $Model;
    }

    public function handle()
    {
        DB::beginTransaction();
            $this->Model->update([
                'date' => Carbon::parse($this->request['date'])->format('Y-m-d'),
                'requisition_for_user_id' => $this->request['user_id'],
                'location_id' => $this->request['location_id'],
                'description' => $this->request['description'],
                'delivery_address' => $this->request['delivery_address'],
                'delivery_date' => Carbon::parse($this->request['delivery_date'])->format('Y-m-d')
            ]);
            $this->Model->products()->delete();
            for ($i=0; $i < count($this->request['product_id']) ; $i++) { 
                dispatch(new CreateRequisitionProduct([
                    'requisition_id' => $this->Model->id,
                    'product_id' =>  $this->request['product_id'][$i],
                    'quantity' =>  $this->request['quantity'][$i],
                ])); 
            }
        DB::commit();
    }
}
