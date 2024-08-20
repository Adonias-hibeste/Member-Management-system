<?php

namespace App\Http\Controllers;


use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function register(){
        return view ('Admin.register');
    }

    public function registerPost(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $admins = new Admin();
        $admins->name = $request->name;
        $admins->email = $request->email;
        $admins->password = Hash::make($request->password);
        $admins->save();

        return redirect()->route('admin.login');
    }

    public function login(){
        return view ('Admin.login');
    }

    public function loginPost(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);


        $credentials = $request->only('email', 'password');


        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();

            if ($user->is_admin == 1) {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/user/userdashboard');
            }
        } else {
            return redirect()->route('admin.register')->with('status', 'Input proper email/password');
        }
    }

}



