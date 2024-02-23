<?php

namespace App\Imports;

use App\Models\ProductIdentifier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductIndentifierImport implements ToModel, WithHeadingRow
{
    protected $product_id;
    protected $location_id;
    protected $batch_id;

    public function __construct($product_id, $location_id, $batch_id)
    {
        $this->product_id = $product_id;
        $this->location_id = $location_id;
        $this->batch_id = $batch_id;
    }

    public function model(array $row)
    {//dd($row);
        //if($row['code'] <= 0){dd($row)};
        return new ProductIdentifier([
            'location_id' => $this->location_id,
            'batch_id' => $this->batch_id,
            'product_id' => $this->product_id,
            'code'     => (string)$row['code'],
            'secondary_code'    => (string)$row['secondary_code']
        ]);
    }
}
