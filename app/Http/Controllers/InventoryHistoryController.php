<?php

namespace App\Http\Controllers;

use App\Models\InventoryHistory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InventoryHistoryController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
           return  $this->datatable($request);
        };

        if($request->has('product_id')){
            $data['ProductHistories'] = InventoryHistory::with(['location','product','product.unit'])
                ->where('product_id', $request['product_id'])
                ->when($request->has('location_id'), function($query) use($request){
                    $query->where('location_id', $request['location_id']);
                })
                ->orderBy('id', 'desc')
                ->get();
        }else{
            $data['ProductHistories'] = [];
        }

        return view('inventory_history.index', $data);
    }

    public function datatable($request)
    {
        return DataTables::of(InventoryHistory::with(['location','product','product.unit','product.unit', 'created_user'])->orderBy('date', 'DESC'))
            ->editColumn('quantity', function(InventoryHistory $ProductHistory) {
                return $ProductHistory->quantity . ' ' . $ProductHistory->product->unit->name;
            })
            ->editColumn('status', function(InventoryHistory $ProductHistory) {
                return ($ProductHistory->type == 'IN') ? '<span class="badge badge-success">IN</span>' : '<span class="badge badge-danger">OUT</span>';
            })
            ->editColumn('type', function(InventoryHistory $ProductHistory) {
                return $ProductHistory->is_active ? '<span class="badge badge-success">Approved</span>' : '<span class="badge badge-danger">Pending</span>';
            })
            ->addColumn('action', function(InventoryHistory $ProductHistory) {
                return 'Not Yet Applicable';
            })
            ->rawColumns(['type', 'status'])
            ->make();
    }
}
