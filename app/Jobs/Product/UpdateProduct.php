<?php

namespace App\Jobs\Product;

use Illuminate\Foundation\Bus\Dispatchable;

class UpdateProduct
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
        $this->Model->update($this->request);
        return $this->Model;
    }
}
