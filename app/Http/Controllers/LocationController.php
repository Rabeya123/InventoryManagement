<?php

namespace App\Http\Controllers;

use App\Http\Requests\Location\CreateLocationRequest;
use App\Http\Requests\Location\UpdateLocationRequest;
use App\Jobs\Location\CreateLocation;
use App\Jobs\Location\UpdateLocation;
use App\Jobs\Location\DeleteLocation;
use App\Models\Location;
use Toastr;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('location.index',[
            'Locations' => Location::all()
        ]);
    }

    public function create()
    {
        return view('location.create');
    }

    public function store(CreateLocationRequest $request)
    {
        try {
            dispatch(new CreateLocation($request->validated()));
            Toastr::success('Location has been created succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { 
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function edit(Location $Location)
    {
        return view('location.edit',[
            'Location' => $Location
        ]);
    }

    public function update(UpdateLocationRequest $request, $id)
    {
        try {
            dispatch(new UpdateLocation($request->validated(), $id));
            Toastr::success('Location has been updated succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { 
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function destroy(Location $Location)
    { 
        try {
            dispatch(new DeleteLocation($Location));
            Toastr::success('Location has been deleted succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }
}
