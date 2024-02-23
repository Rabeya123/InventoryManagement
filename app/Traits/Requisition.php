<?php

namespace App\Traits;

use App\Models\Requisition AS RequisitionModel;

trait Requisition
{
    public function getCodeNumber()
    {
       return 'RE-' . date('dmy')  . '' . (RequisitionModel::count('id') + 1) ;
    }
}
