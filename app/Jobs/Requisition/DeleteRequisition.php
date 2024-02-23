<?php

namespace App\Jobs\Requisition;

use App\Models\Requisition;
use App\Models\RequisitionProduct;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class DeleteRequisition
{
    use Dispatchable;

    protected $Model; 

    public function __construct(Requisition $Model)
    {
        $this->Model = $Model;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();
            $this->Model->products()->delete();
            $this->Model->delete();
        DB::commit();
    }
}
