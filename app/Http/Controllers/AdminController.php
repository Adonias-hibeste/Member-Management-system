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
        $currentStep = $request->input('current_step', 1);

        // Step 1: Profile Information
        if ($currentStep == 1) {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'age' => 'required|numeric|min:18|max:100',
                'address' => 'required|string',
                'gender' => 'required|in:male,female',
                'phone_number' => 'required',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Handle image upload
            if ($request->hasFile('profile_image')) {
                $imagePath = $request->file('profile_image')->store('profiles', 'public');
            } else {
                $imagePath = null;  // No image provided
            }

            // Store profile details in the session
            session()->put('profile_data', [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'age' => $request->age,
                'address' => $request->address,
                'gender' => $request->gender,
                'image' => $imagePath,
                'phone_number' => $request->phone_number,
            ]);

            // Move to Step 2
            return view('Admin.register', ['currentStep' => 2]);
        }

        // Step 2: Account Details
        if ($currentStep == 2) {
            $request->validate([
                'user_name' => 'required|string|max:255|unique:users,User_name',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:8',
            ]);

            // Store account details in session
            session()->put('account_data', [
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Move to Step 3
            return view('Admin.register', ['currentStep' => 3]);
        }

        // Step 3: Payment and Final Submission
        if ($currentStep == 3) {
            $request->validate([
                'membershipType' => 'required|string',
            ]);

            // Retrieve data from session
            $profileData = session()->get('profile_data');
            $accountData = session()->get('account_data');

            // Save Profile
            $profile = Profile::create([
                'first_name' => $profileData['first_name'],
                'last_name' => $profileData['last_name'],
                'image' => $profileData['image'],
                'age' => $profileData['age'],
                'address' => $profileData['address'],
                'gender' => $profileData['gender'],
                'phone_number' => $profileData['phone_number'],
            ]);

            // Save User Account
            $user = User::create([
                'user_name' => $accountData['user_name'],
                'email' => $accountData['email'],
                'password' => $accountData['password'],
            ]);

            // Clear session data after saving
            session()->forget(['profile_data', 'account_data']);

            // Redirect to success page
            return redirect()->route('Admin.login')->with('success', 'Registration completed successfully!');
        }
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



