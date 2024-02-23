<?php

namespace App\Traits;

use App\Models\Inventory AS InventoryModel;

trait Inventory
{
    public function getCodeNumber()
    {
       return 'IN-' . date('my') . (InventoryModel::count('id') + 1) ;
    }
}
