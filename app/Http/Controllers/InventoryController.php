<?php

namespace App\Http\Controllers;

use App\Http\Requests\Inventory\InventoryRequest;
use App\Imports\ExcelToColleciton;
use App\Imports\ProductIndentifierImport;
use App\Jobs\Inventory\CreateInventory;
use App\Jobs\Inventory\CreateTransfarIventory;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductIdentifier;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Toastr;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $LocationProductStocks = DB::select("
            SELECT 		IH.product_id,
                        L.name AS LocationName,
                        P.name AS ProductName,
                        P.code AS ProductCode,
                        U.name AS UnitName,
                        L.id AS LocationID,
                        SUM(IF(IH.type = 'IN', IH.quantity, 0)) AS ProductIN,
                        SUM(IF(IH.type = 'OUT', IH.quantity, 0)) AS ProductOUT,
                        MAX(IH.created_at) AS LastUpdated
            FROM 		inventory_histories AS IH
            LEFT JOIN 	products AS P ON P.id = IH.product_id
            LEFT JOIN 	units AS U ON P.unit_id = U.id
            LEFT JOIN 	locations AS L ON L.id = IH.location_id
            GROUP BY 	location_id, product_id;
        ");

        $ProductStocks = DB::select("
            SELECT 		IH.product_id, IH.location_id,
                        P.name AS ProductName,
                        P.code AS ProductCode,
                        U.name AS UnitName,
                        IFNULL(UP.floating_quantity, 0) AS FloatingQuantity,
                        SUM(IF(IH.type = 'IN', IH.quantity, 0)) AS ProductIN,
                        SUM(IF(IH.type = 'OUT', IH.quantity, 0)) AS ProductOUT,
                        MAX(IH.created_at) AS LastUpdated
            FROM 		inventory_histories AS IH
            LEFT JOIN 	products AS P ON P.id = IH.product_id
            LEFT JOIN 	units AS U ON P.unit_id = U.id
            LEFT JOIN 	locations AS L ON L.id = IH.location_id
            LEFT JOIN 	(
                                SELECT 		PI.product_id AS user_product_id,
                                            COUNT(0) AS floating_quantity
                                FROM        product_identifiers AS PI
                                LEFT JOIN 	requestion_product_identifer AS RPI ON RPI.indentifier_id = PI.id
                                WHERE 	    PI.float_user_id IS NOT NULL
                                AND 	    PI.CustomerID IS NULL
                                GROUP BY 	PI.product_id
                        ) AS UP ON UP.user_product_id = IH.product_id
            GROUP BY 	IH.product_id;
        ");

        return view('inventory.index',[
            'LocationProductStocks' => $LocationProductStocks,
            'ProductStocks' => $ProductStocks,
            'Locations' => Location::all()
        ]);
    }

    public function create(Request $request)
    {
        //transfar
        if($request->type_id == 3){
            return view('inventory.transfar',[
                'Locations' => Location::isActive()->get(),
            ]);
        }

        //addtion
        return view('inventory.create',[
            'Products' => Product::isActive()->get(),
            'PurchaseOrders' => PurchaseOrder::IsApproved()->get(),
            'Locations' => Location::isActive()->get(),
        ]);
    }

    public function store(InventoryRequest $request)
    { //return $request;
        //Storage::put('example.txt', 'Contents');
        try {
            DB::beginTransaction();

                //transafar
                if($request->type_id == 3) {
                    dispatch( new CreateTransfarIventory($request->toArray()));
                    Toastr::success('Inventory has been transferred succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
                    DB::commit();
                    return redirect()->back();
                }

                //start product add
                $termporary_batch = [];
                $file_names = [];
                for ($i=0; $i <count($request->product_id) ; $i++) {
                    if(!empty($request->identifier[$i])){
                        $unique_id = time();
                        $termporary_batch[$i]['batch'] = $unique_id;
                        $termporary_batch[$i]['product_id'] = $request->product_id[$i];
                        $file_name = 'identifiers/' . time() . '.' . $request->identifier[$i]->extension(); //dd($request->identifier[$i]);
                        Storage::put( $file_name , file_get_contents($request->identifier[$i]));
                        $file_names[] = $file_name;
                        Excel::import(new ProductIndentifierImport($request->product_id[$i], $request['from_location_id'], $unique_id), $request->identifier[$i]);
                    }
                }
                $request['temporary_batch'] = $termporary_batch; //dd(ProductIdentifier::limit(5)->orderBy('id','desc')->get());
                $request['file_names'] = $file_names;
                dispatch_sync(new CreateInventory($request->except('identifier')), ); //dd(false);
                //end product add

            DB::commit();
            Toastr::success('Inventory has been created succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { dd($th);
            DB::rollBack();
            if($th->errorInfo[1] == 1062){
                Toastr::error('Upload file has duplicate data!', 'Error', ["positionClass" => "toast-top-right"]);
            }else{
                Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            }
            return redirect()->back();
        }
    }
}
