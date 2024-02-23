<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Requests\Contact\CreateContactRequest;
use App\Http\Requests\Contact\UpdateContctRequest;
use App\Jobs\Contact\CreateContact;
use App\Jobs\Contact\UpdateContact;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\Request;
use Toastr;

class ContactController extends Controller
{
    public function index() 
    {
        return view('contact.index', [
            'Contacts' => Contact::all()
        ]);
    }

    public function create()
    {
        return view('contact.create', [
            'Companies' => Company::select('id', 'name')->get()
        ]);
    }

    public function store(CreateContactRequest $request)
    {
        try {
            $Model = Company::findOrFail($request->company_id); //dd($Model);
            dispatch(new CreateContact( $Model, $request->validated()));
            Toastr::success('Contact has been created succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { dd($th);
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function edit(Contact $Contact)
    {
        return view('contact.edit',[
            'Contact' => $Contact,
            'Companies' => Company::select('id', 'name')->get()
        ]);
    }

    public function update(UpdateContctRequest $request, Contact $Contact)
    { 
        try {
            dispatch(new UpdateContact($Contact,$request->validated()));
            Toastr::success('Contact has been updated succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { dd($th);
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

}
