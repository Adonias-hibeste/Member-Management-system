<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Profile;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RegUserController extends Controller
{
    public function Users(){
        $profiles= Profile::with('user')->get();
        $staffs=Admin::all();
        $roles=Role::all();
        return view("admin.registeredusers",compact("profiles","staffs","roles"));
    }


    public function EditUser($user_id){
        $user= Admin::find($user_id);
        return view("admin.edituser",compact("user"));
    }
    public function Update(Request $request , $user_id){
        $user= Admin::find($user_id);
        if($user)
        {
            $user->is_admin=$request->is_admin;

            $user->update();
            return redirect()->route('admin.registeredusers')->with('message','updated successfully');
        }
        return redirect()->route('admin.registeredusers')->with('message','no user found');
    }




}
