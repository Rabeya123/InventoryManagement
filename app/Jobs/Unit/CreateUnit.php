<?php

namespace App\Jobs\Unit;

use App\Models\Unit;


use Illuminate\Foundation\Bus\Dispatchable;

class CreateUnit 
{
    use Dispatchable;
   
    protected $request; 

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function handle()
    {
        return Unit::create($this->request);
    }
}
