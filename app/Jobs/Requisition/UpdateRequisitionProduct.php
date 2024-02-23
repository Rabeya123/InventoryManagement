<?php

namespace App\Jobs\Requisition;

use App\Models\RequisitionProduct;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateRequisitionProduct
{
    use Dispatchable;

    public function __construct(array $request, RequisitionProduct $Model)
    {
        $this->request = $request;
        $this->Model = $Model;
    }

    public function handle()
    {
        $this->Model->update($this->request);
        return $this->Model->refresh();
    }
}
