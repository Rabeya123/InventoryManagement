<?php

namespace App\Jobs\Requisition;

use App\Models\Requisition;
use App\Models\RequisitionProduct;
use App\Traits\Requisition as TraitsRequisition;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class CreateRequisition
{
    use Dispatchable, TraitsRequisition;

    protected $request; 

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function handle()
    {
        DB::beginTransaction();
            $Requisition = Requisition::create([
                'date' => Carbon::parse($this->request['date'])->format('Y-m-d'),
                'code' => $this->getCodeNumber(),
                'requisition_for_user_id' => $this->request['user_id'],
                'description' => $this->request['description'],
                'delivery_address' => $this->request['delivery_address'],
                'delivery_date' => Carbon::parse($this->request['delivery_date'])->format('Y-m-d'),
                'contact_id' => isset($this->request['contact_id']) ? $this->request['contact_id'] : null,
            ]);
            for ($i=0; $i < count($this->request['product_id']) ; $i++) { 
                dispatch(new CreateRequisitionProduct([
                    'requisition_id' => $Requisition->id,
                    'product_id' =>  $this->request['product_id'][$i],
                    'quantity' =>  $this->request['quantity'][$i],
                ])); 
            }
        DB::commit();
    }
}
