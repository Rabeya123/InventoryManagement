<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseOrder\PurchaseOrderRequest;
use App\Jobs\Purchase\CreatePurchaseOrder;
use App\Jobs\Purchase\UpdatePurchaseOrder;
use App\Models\Contact;
use App\Models\Location;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Traits\PurchaseOrder as TraitsPurchaseOrder;
use Illuminate\Http\Request;
use Toastr;

class PurchaseOrderController extends Controller
{
    use TraitsPurchaseOrder;

    public function index()
    { 
        return view('purchase_order.index',[
            'PurchaseOrders' => PurchaseOrder::with('orders')->get()
        ]);
    }

    public function create()
    {
        return view('purchase_order.create', [
            'code_no' => $this->getCodeNumber(),
            'Products' => Product::IsActive()->get(),
            'Contacts' => Contact::IsActive()->get(),
        ]);
    }
    
    public function store(PurchaseOrderRequest $request)
    {
        try {
            dispatch(new CreatePurchaseOrder($request->validated()));
            Toastr::success('Purchase order has been created succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { dd($th);
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function edit(PurchaseOrder $purchaseOrder) 
    {
        return view('purchase_order.edit', [
            'PurchaseOrder' =>  $purchaseOrder,
            'Products' => Product::IsActive()->get(),
            'Contacts' => Contact::IsActive()->get(),
        ]);
    }

    public function show(Request $request, PurchaseOrder $purchaseOrder)
    { 
        if($request->has('is_print')){
            return view('purchase_order.print', [
                'PurchaseOrder' => $purchaseOrder->load('orders.product')
            ]);
        }
        return $purchaseOrder->load('orders.product');
    }

    public function update(PurchaseOrderRequest $request, PurchaseOrder $purchaseOrder)
    {
        try {
            dispatch(new UpdatePurchaseOrder($purchaseOrder, $request->validated()));
            Toastr::success('Purchase order has been updated succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function destroy(PurchaseOrder $purchaseOrder) 
    {
        return abort(403);
    }
}
