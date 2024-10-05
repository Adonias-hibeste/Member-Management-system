<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function addRole(){
        $permissions=Permission::all();
        return view('Admin.Role.createRole',compact('permissions'));
    }
}
