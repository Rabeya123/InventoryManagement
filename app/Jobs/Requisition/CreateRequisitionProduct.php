<?php

namespace App\Jobs\Requisition;

use App\Models\RequisitionProduct;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateRequisitionProduct
{
    use Dispatchable;

    protected $request; 

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return RequisitionProduct::create($this->request);
    }
}
