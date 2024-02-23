<?php

namespace App\Jobs\Purchase;

use App\Models\PurchaseOrderCondition;
use Illuminate\Foundation\Bus\Dispatchable;

class CreatePurchaseOrderCondition
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

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return PurchaseOrderCondition::create($this->request);
    }
}
