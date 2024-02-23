<?php

namespace App\Traits;

use App\Models\PurchaseOrder AS PurchaseOrderModel;

trait PurchaseOrder
{
    public function getCodeNumber()
    {
       return 'PO-' . date('dmy')  . '-Bondstein-' . (PurchaseOrderModel::count('id') + 1) ;
    }
}
