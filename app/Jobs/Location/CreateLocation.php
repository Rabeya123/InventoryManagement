<?php

namespace App\Jobs\Location;

use App\Models\Location;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateLocation
{
    use Dispatchable;
    
    protected $request; 

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function handle()
    {
        return Location::create($this->request);
    }
}
