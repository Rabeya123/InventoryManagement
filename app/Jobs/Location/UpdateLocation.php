<?php

namespace App\Jobs\Location;

use App\Models\Location;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateLocation
{
    protected $request; 
    protected $id;

    public function __construct(array $request, $id)
    {
        $this->request = $request;
        $this->id = $id;
    }

    public function handle()
    {
        $Location = Location::findOrFail($this->id);
        $Location->update($this->request);
        $Location->refresh();
        return $Location;
    }
}
