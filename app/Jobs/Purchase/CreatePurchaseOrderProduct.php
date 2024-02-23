<?php

namespace App\Jobs\Purchase;

use App\Models\PurchaseOrderProduct;
use Illuminate\Foundation\Bus\Dispatchable;

class CreatePurchaseOrderProduct
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
        return PurchaseOrderProduct::create($this->request);
    }
}
