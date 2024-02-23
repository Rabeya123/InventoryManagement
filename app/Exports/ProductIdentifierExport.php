<?php

namespace App\Exports;

use App\Models\ProductIdentifier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductIdentifierExport implements FromQuery, WithHeadings
{
    use Exportable;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        return ProductIdentifier::query()
            ->select(DB::raw('product_identifiers.id AS ProductIndentiferID,
                DATE_FORMAT(product_identifiers.created_at, "%d-%b-%Y"),
                product_batchs.code AS BCode,
                products.name AS PName,
                locations.name AS LName,
                secondary_code,
                product_identifiers.code AS ACode,
                users.name AS UName,
                DATE_FORMAT(product_identifiers.float_user_add_at, "%d-%b-%Y"),
                customers.name AS CName,
                providers.name AS PAName,
                IF(product_identifiers.float_user_id AND product_identifiers.CustomerID,
                    "Installed",
                    IF(product_identifiers.float_user_id,
                        "Float", "Not Yet Assign"))
            '))
            ->leftJoin('users', 'users.id', 'float_user_id')
            ->leftJoin('products', 'products.id', 'product_id')
            ->leftJoin('product_batchs', 'product_batchs.id', 'batch_id')
            ->leftJoin('customers', 'customers.CustomerID', 'product_identifiers.CustomerID')
            ->leftJoin('providers', 'providers.ProviderID', 'customers.ProviderID')
            ->leftJoin('locations', 'locations.id', 'product_identifiers.location_id')
            ->when($this->request->indentifier_status_id, function($query) { //dd($this->request->indentifier_status_id);
                if($this->request->indentifier_status_id == 1){
                   return $query->whereNull('product_identifiers.float_user_id');
                }elseif($this->request->indentifier_status_id == 2){
                    return $query->whereNotNull('product_identifiers.float_user_id')
                        ->whereNotNull('product_identifiers.CustomerID');
                }elseif($this->request->indentifier_status_id == 3){ //dd(10);
                    return $query->whereNotNull('product_identifiers.float_user_id')
                        ->whereNotNull('product_identifiers.CustomerID');
                }
            })
            ->when($this->request->start_date && $this->request->end_date, function($query) {
                $query->whereBetween('product_identifiers.created_at', [Carbon::parse($this->request->start_date)->format('Y-m-d 00:00:00'), Carbon::parse($this->request->end_date)->format('Y-m-d 23:59:59')]);
            });
    }

    public function headings(): array
    {
        return [
            '#',
            'Date',
            'Batch',
            'Product',
            'Warehouse',
            'SecondaryCode/BST',
            'Code/IMEI',
            'Technician',
            'DeliveryDate',
            'Customer',
            'Provider',
            'Status'
        ];
    }
}
