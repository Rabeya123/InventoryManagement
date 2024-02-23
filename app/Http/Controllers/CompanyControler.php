<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Jobs\Company\CreateCompany;
use App\Jobs\Company\DeleteCompany;
use App\Jobs\Company\UpdateCompany;
use App\Models\Company;
use Toastr;

class CompanyControler extends Controller
{
    public function index()
    {
        // return Company::all();
        return view('supplier.index', [
            'Suppliers' => Company::select('id', 'name','address', 'is_active')->get()
        ]);
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(CreateCompanyRequest $request)
    {
        try {
            dispatch(new CreateCompany($request->validated()));
            Toastr::success('Supplier  has been created succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { 
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function edit($Company)
    {
        return view('supplier.edit',[
            'Company' => Company::findOrFail($Company)
        ]);
    }

    public function update(UpdateCompanyRequest $request, Company $Company)
    { 
        try {
            dispatch(new UpdateCompany($Company,$request->validated()));
            Toastr::success('Company  has been updated succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function destroy(Company $Company)
    { abort(403);
        try {
            dispatch(new DeleteCompany($Company));
            Toastr::success('Company has been deleted succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { 
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }
}
