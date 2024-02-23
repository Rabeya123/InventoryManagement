<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Jobs\User\CreateUser;
use App\Jobs\User\UpdateUser;
use App\Models\CustomerBill;
use App\Models\Location;
use App\Models\Role;
use Illuminate\Http\Request;
use Auth;
use Toastr;
use PDF;
use App\Models\User;
use Illuminate\Support\Carbon;
use Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('user.index',[
            'Users' => User::all()
        ]);
    }

    public function create()
    {
        if(auth()->user()->is_admin){
            $ExpectRoles = [1];
        }else{
            $ExpectRoles = [1,2];
        }
        
        return view('user.create',[
            'Roles' => Role::whereNotIn('id', $ExpectRoles)->get(['id','name']),
            'Locations' => Location::isActive()->get(['id','name'])
        ]);
    }

    public function store(CreateUserRequest $request)
    {
        try {
            dispatch(new CreateUser($request->validated()));
            Toastr::success('User has been created succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { dd($th);
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function edit(User $User)
    {
        if(!$User->is_admin){
            abort(403);
        }

        if(auth()->user()->is_admin){
            $ExpectRoles = [1];
        }else{
            $ExpectRoles = [1,2];
        }

        return view('user.edit',[
            'User' => $User,
            'Roles' => Role::whereNotIn('id', $ExpectRoles)->get(['id','name'])
        ]);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        if($request->role_id == 1){
            abort(403);
        }

        try {
            dispatch(new UpdateUser($request->validated(), $id));
            Toastr::success('User has been updated succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { dd($th);
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function destroy(User $user) 
    {
        return abort(403);
    }
}
