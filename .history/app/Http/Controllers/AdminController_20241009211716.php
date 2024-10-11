<?php

namespace App\Http\Controllers;


use App\Models\Admin;
use App\Models\Membership;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
        'password' => Hash::make($request->password), // Hash the password
    ]);

    $profile = Profile::create([
        'user_id' => $user->id,
        'membership_id' => $request->membership,
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









    public function registerapp(Request $request)
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

        // Save the user data
        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
        ]);

        // Save the profile data
        $profile = Profile::create([
            'user_id' => $user->id,
            'membership_id' => $request->membership,
            'age' => $request->age,
            'address' => $request->address,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
        ]);

        return response()->json(['message' => 'Registration completed successfully!', 'user' => $user, 'profile' => $profile], 201);
    }


    public function loginapp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $profile = Profile::where('user_id', $user->id)->first();

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'profile' => $profile,
        ], 200);
    }public function updateapp(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'age' => 'required|numeric|min:18|max:100',
            'address' => 'required|string',
            'gender' => 'required|in:male,female',
            'phone_number' => 'required',
            'membership' => 'required|integer',
            'email' => 'required|email|max:255|unique:users,email,' . $request->user()->id,
            'current_password' => 'required|string|min:8',
            'new_password' => 'nullable|string|min:8',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 401);
        }

        $user->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => $request->new_password ? Hash::make($request->new_password) : $user->password,
        ]);

        $user->profile->update([
            'membership_id' => $request->membership,
            'age' => $request->age,
            'address' => $request->address,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
        ]);

        return response()->json(['message' => 'Profile updated successfully!', 'user' => $user, 'profile' => $user->profile], 200);
    }public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Delete the user
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }


}












