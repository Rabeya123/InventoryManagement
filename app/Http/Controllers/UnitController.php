<?php

namespace App\Http\Controllers;
use App\Http\Requests\Unit\CreateUnitRequest;
use App\Http\Requests\Unit\UpdateUnitRequest;
use App\Jobs\Unit\CreateUnit;
use App\Jobs\Unit\UpdateUnit;
use App\Jobs\Unit\DeleteUnit;
use Illuminate\Http\Request;
use App\Models\Unit;
use Toastr;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('unit.index',[
            'Units' => Unit::all()
        ]);
    }

    public function create()
    {
        return view('unit.create');
    }

    public function store(CreateUnitRequest $request)
    {
        try {
            dispatch(new CreateUnit($request->validated()));
            Toastr::success('Location has been created succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { 
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function edit(Unit $Unit)
    {
        return view('unit.edit',[
            'Unit' => $Unit
        ]);
    }

    public function update(UpdateUnitRequest $request, $id)
    {
        try {
            dispatch(new UpdateUnit($request->validated(), $id));
            Toastr::success('Location has been updated succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { 
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function destroy(Unit $Unit)
    { 
        try {
            dispatch(new DeleteUnit($Unit));
            Toastr::success('Location has been deleted succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }


}
