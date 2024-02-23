<?php

namespace App\Http\Controllers;

use App\Http\Requests\Requisition\RequisitionRequest;
use App\Jobs\Requisition\DeleteRequisition;
use App\Jobs\Requisition\ApprovedRequisition;
use App\Jobs\Requisition\CreateRequisition;
use App\Jobs\Requisition\UpdateRequisition;
use App\Models\Location;
use App\Models\Product;
use App\Models\Requisition;
use App\Models\User;
use Illuminate\Http\Request;
use Toastr;

class RequisitionController extends Controller
{
    public function index()
    {
        return view('requisition.index', [
            'Requisitions' => Requisition::withSum('products', 'quantity')
                ->orderBy('id', 'desc')
                ->get(),
        ]);
    }

    public function create()
    {
        return view('requisition.create', [
            'Users' => User::whereNotIn('role_id',[1, 2])->get(),
            'Products' => Product::all(),
            'Locations' => Location::isActive()->get()
        ]);
    }

    public function show(Request $request, Requisition $requisition)
    {
        if($request->has('is_print')){
            return view('requisition.print', [
                'Requisition' => $requisition->load('products', 'indentifiers'),
                'Locations' => Location::isActive()->get(),
            ]);
        }

        return view('requisition.show', [
            'Requisition' => $requisition->load('products', 'indentifiers'),
            'Locations' => Location::isActive()->get(),
        ]);
    }

    public function store(RequisitionRequest $request)
    {
        try {
            $Requsition = dispatch(new CreateRequisition($request->validated()));
            Toastr::success('Requisition has been created succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { dd($th);
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function edit(Requisition $requisition)
    {
        return view('requisition.edit', [
            'Users' => User::whereNotIn('role_id',[1, 2])->get(),
            'Products' => Product::all(),
            'Requisition' => $requisition->load('products'),
            'Locations' => Location::isActive()->get(),
        ]);
    }

    public function update(RequisitionRequest $request, Requisition $requisition)
    {
        try {
            if($request->has('is_approved')) {
                if(COUNT($request['identifier_id']) != COUNT(array_unique($request['identifier_id']))){
                    Toastr::error('Your selected imtems has duplicate value!', 'Error', ["positionClass" => "toast-top-right"]);
                    return redirect()->back();
                }
                dispatch(new ApprovedRequisition($request->validated(), $requisition));
                if($request->has('is_print')) {
                    return redirect()->route('requisitions.show',['requisition' => $requisition, 'is_print' => 1 ]);
                }
                Toastr::success('Requisition has been approved succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            }else{
                dispatch(new UpdateRequisition($request->validated(), $requisition));
                Toastr::success('Requisition has been updated succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            }
            return redirect()->back();
        } catch (\Throwable $th) { dd($th);
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function destroy(Requisition $requisition)
    {
        try {
            dispatch(new DeleteRequisition($requisition));
            Toastr::success('Requisition has been deleted succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { //dd($th);
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }
}
