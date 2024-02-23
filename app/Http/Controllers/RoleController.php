<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        // Role::create([
        //     'name' => 'Super Admin'
        // ]);

        // Role::create([
        //     'name' => 'Admin'
        // ]);

        // Role::create([
        //     'name' => 'Manager'
        // ]);

        // Role::create([
        //     'name' => 'Executive'
        // ]);

        // Role::create([
        //     'name' => 'Supervisor'
        // ]);

        // Role::create([
        //     'name' => 'Technician'
        // ]);
        

        return abort(403);
    }
}
