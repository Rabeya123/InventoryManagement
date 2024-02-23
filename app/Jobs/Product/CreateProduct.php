<?php

namespace App\Jobs\Product;

use App\Models\Product;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateProduct
{
    use Dispatchable;

    protected $request; 

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function handle()
    { //dd($this->request);
        Product::create($this->request);
    }
}
