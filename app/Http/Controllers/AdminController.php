<?php

namespace App\Http\Controllers;


use App\Models\Admin;
use App\Models\Membership;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function register(){
      $memberships= Membership::all();
        return view ('Admin.register',compact('memberships'));
    }

    public function registerPost(Request $request)
    {

            $request->validate([
                'full_name' => 'required|string|max:255',
                'age' => 'required|numeric|min:18|max:100',
                'address' => 'required|string',
                'gender' => 'required|in:male,female',
                'phone_number' => 'required',
                'membership' => 'required|integer',
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
                'membership_id' => $request->membership,
                'age' => $request->age,
                'membership_endDate' => Carbon::now()->addDays(30),
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

        else if (Auth::guard(name: 'web')->attempt($credentials)) {
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

    public function create_staff(){
        $roles=Role::all();
        return view('Admin.staff.createStaff',compact('roles'));
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'gender'=>'required',
            'email'=>['required',
                     'email',
                    'unique:admins,email'],
            'phone_number'=>[
                'required',
                'digits:10',
                'unique:admins,phone',
            ],
            'image' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
            'address'=>'required|string',
            'password'=>'required',
            'roles'=>'required',
        ]);

        if ($request->hasFile('image')){
            $file = $request->file('image');
            $filename=time(). "." . $file->getClientOriginalExtension();

           $file->move('uploads/staffs',$filename);


        }

        $admin = Admin::create([
            'full_name'=>$request->name,
            'gender'=>$request->gender,
            'email'=>$request->email,
            'phone'=>$request->phone_number,
            'address'=>$request->address,
            'password'=>bcrypt($request->password),
            'image'=>$filename,

        ]);
        $admin->roles()->attach($request->roles);

        return redirect()->route('admin.registeredusers');
    }

}



