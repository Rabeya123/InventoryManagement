<?php

namespace App\Traits;

use App\Models\ProductBatch;

trait Batch
{
    public function getBatchNumber()
    {
       return 'B'. date('dmy') . (ProductBatch::count('id') + 1) ;
    }
}
