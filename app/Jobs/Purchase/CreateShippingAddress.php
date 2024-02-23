<?php

namespace App\Jobs\Purchase;

use App\Models\ShippingAddress;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateShippingAddress
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
        return ShippingAddress::create($this->request);
    }
}
