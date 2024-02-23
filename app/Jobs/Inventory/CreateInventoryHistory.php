<?php

namespace App\Jobs\Inventory;

use App\Models\InventoryHistory;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateInventoryHistory
{
    use Dispatchable;

    protected $request; 

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function handle()
    {
       return InventoryHistory::create($this->request);
    }
}
