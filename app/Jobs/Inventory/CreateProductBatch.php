<?php

namespace App\Jobs\Inventory;

use App\Models\ProductBatch;
use App\Traits\Batch;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateProductBatch
{
    use Dispatchable, Batch;

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
        $this->request['code'] = $this->getBatchNumber(); //dd($this->request);
        return ProductBatch::create($this->request);
    }
}
