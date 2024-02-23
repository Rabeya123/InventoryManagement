<?php

namespace App\Http\Controllers;

use App\Exports\ProductIdentifierExport;
use App\Models\ProductIdentifier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ProductIdentifierController extends Controller
{
    public function index(Request $request)
    {
       if($request->ajax()){
            return $this->search($request);
       };

       if($request->has('user_id') && $request->has('product_id')){
            $ProductIdentifiers = ProductIdentifier::with('batch')
                ->where(['float_user_id' => $request['user_id'], 'product_id' => $request['product_id']])
                ->when($request['is_floating'], function($quyer) use($request) {
                    $quyer->whereNull('CustomerID');
                })
                ->get();
                return view('identifier.index',[
                    'ProductIdentifiers' =>  $ProductIdentifiers
                ]);
        }

        if($request->has('download')){
            return Excel::download(new ProductIdentifierExport($request), "indentifers_" . date('d_m_Y_h_i_s') . ".xlsx");
        }

        return view('identifier.index',[
            'ProductIdentifiers' =>  []
        ]);
    }

    public function show(ProductIdentifier $productIdentifier)
    {
        return $productIdentifier->load('product','batch');
    }

    public function datatable(Request $request)
    { //return $request;
        $query = ProductIdentifier::with('batch','customer.provider','user','product','location')
            ->when($request->has('indentifier_status_id'), function($q) use($request){
                if($request->indentifier_status_id == 1){
                    $q->whereNull('float_user_id');
                }elseif($request->indentifier_status_id == 2){
                    $q->whereNotNull('float_user_id')
                        ->whereNull('CustomerID');
                }elseif($request->indentifier_status_id == 3){
                    $q->whereNotNull('float_user_id')
                        ->whereNotNull('CustomerID');
                }
            })
            ->when($request->has('start_date') == '' && $request->has('end_date') == '', function($query) use($request){
                $query->whereBetween('created_at', [Carbon::parse($request->start_date)->format('Y-m-d 00:00:00'), Carbon::parse($request->end_date)->format('Y-m-d 23:59:59')]);
            })
            ->orderBy('id', 'desc');

        return DataTables::of($query)
            ->editColumn('status', function(ProductIdentifier $ProductIdentifier) {
                if(isset($ProductIdentifier->customer) &&  $ProductIdentifier->customer->name != ''){
                    return '<span class="badge badge-danger">Installed</span>' ;
                }else if($ProductIdentifier->user->name){
                    return '<span class="badge badge-warning">Float</span>';
                }else{
                    return '<span class="badge badge-success">Not Yet Assign</span>' ;
                }
            })
            ->editColumn('created_at', function(ProductIdentifier $ProductIdentifier) {
                return Carbon::parse($ProductIdentifier->created_at)->format('d-m-Y h:i A');
            })
            ->editColumn('customer.name', function(ProductIdentifier $ProductIdentifier) {
                return $ProductIdentifier->customer ? $ProductIdentifier->customer->name : "-";
            })
            ->editColumn('location.name', function(ProductIdentifier $ProductIdentifier) {
                return ($ProductIdentifier->float_user_id) ? "-" : $ProductIdentifier->location->name;
            })
            ->editColumn('customer.provider.name', function(ProductIdentifier $ProductIdentifier) {
                return $ProductIdentifier->customer ? $ProductIdentifier->customer->provider->name : "-";
            })
            ->addColumn('action', function(ProductIdentifier $ProductIdentifier) {
                if(auth()->user()->isActive){
                    return 'Not Yet Applicable';
                }else{
                    return 'Not Yet Applicable';
                }

            })
            ->rawColumns(['status'])
            ->make();
    }

    public function search($request)
    {
        if($request->has('search')) { //dd($request->location_id);
            return response()->json([
                'results' => DB::table('product_identifiers AS PI')
                    ->select(DB::raw("PI.id, PI.float_user_id, PI.product_id, PI.location_id, CONCAT( P.name, '; ' ,'Indentification: ', PI.code,  '; ' , 'BST: ', PI.secondary_code) as text"))
                    ->leftJoin('products as P','PI.product_id', 'P.id')
                    ->where('PI.location_id', $request->location_id)
                    ->whereNull('PI.float_user_id')
                    ->when($request->has('product_ids'), function($query) use($request) {
                        $query->whereIn('product_id', $request['product_ids']);
                    })
                    ->where(function($query)use($request){
                        $query->where('PI.code', 'like', "%{$request->search}%")
                            ->orWhere('PI.secondary_code', 'like', "%{$request->search}%");
                    })
                    ->get()
            ]);
        }else{
            return response()->json([
                'results' => DB::table('product_identifiers AS PI')
                    ->where('PI.location_id', $request->location_id)
                    ->whereNull('float_user_id')
                    // ->whereIn('product_id', $request->product_ids)
                    ->when($request->has('product_ids'), function($query) use($request) {
                        $query->whereIn('product_id', $request['product_ids']);
                    })
                    ->select(DB::raw("PI.id, CONCAT( P.name, '; ' ,'Indentification: ', PI.code,  '; ' , 'BST: ', PI.secondary_code) as text"))
                    ->leftJoin('products as P','PI.product_id', 'P.id')
                    ->get()
            ]);
        }
    }
}
