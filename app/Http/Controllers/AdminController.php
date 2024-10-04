<?php

namespace App\Http\Controllers;


use App\Models\Admin;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function register(){
        $currentStep=request('current_step',1);
        return view ('Admin.register',compact('currentStep'));
    }

    public function registerPost(Request $request)
    {

            $request->validate([
                'full_name' => 'required|string|max:255',
                'age' => 'required|numeric|min:18|max:100',
                'address' => 'required|string',
                'gender' => 'required|in:male,female',
                'phone_number' => 'required',
                'user_name' => 'required|string|max:255|unique:profiles,user_name',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:8',

            ]);


    $user = User::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $profile = Profile::create([
                'user_id'=>$user->id,
                'user_name' => $request->user_name,
                'age' => $request->age,
                'address' => $request->address,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
            ]);
            return redirect()->route('admin.login')->with('success', 'Registration completed successfully!');
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
            $admin = Auth::guard('admin')->user(); // Fetch admin user

            if ($admin) {
                return redirect()->intended('/admin/dashboard');
            }
        }

        else if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user(); // Fetch user
            if ($user) {
                //dd($user);
                return redirect()->intended('/user/userdashboard');
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

}



