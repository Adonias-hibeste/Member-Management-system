<?php

namespace App\Http\Controllers;

use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function create(){
        $permissions=Permission::all();
        return view('Admin.Role.createRole',compact('permissions'));
    }

    public function store(Request $request){

        $request->validate([
            'role_name'=>'required|string|max:255|unique:roles,name',
            'permissions'=>'required|array',
        ]);

        $role = Role::create([
            'name'=>$request->role_name,
            'guard_name' => 'admin'
        ]);

        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.registeredusers')->with('message','Role created successfully');


    }
}
