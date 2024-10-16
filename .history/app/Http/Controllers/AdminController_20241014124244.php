<?php

namespace App\Http\Controllers;
// Ensure this is included at the top of your AuthController


use App\Models\User;
use App\Models\Admin;
use App\Models\Profile;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;




use Illuminate\Validation\ValidationException;

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
    }
    public function updateapp(Request $request)
{
    try {
        // Validate the incoming request data
        $request->validate([
            'full_name' => 'required|string|max:255',
            'age' => 'required|numeric|min:18|max:100',
            'address' => 'required|string',
            'gender' => 'required|in:male,female',
            'phone_number' => 'required|string',
            'membership' => 'required|integer',
            'email' => 'required|email|max:255|unique:users,email,' . $request->user()->id,
        ]);

        $user = $request->user();

        // Update user information (without password)
        $user->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
        ]);

        // Update or create user profile information
        if (!$user->profile) {
            $user->profile()->create([
                'membership_id' => $request->membership,
                'age' => $request->age,
                'address' => $request->address,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
            ]);
        } else {
            $user->profile->update([
                'membership_id' => $request->membership,
                'age' => $request->age,
                'address' => $request->address,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
            ]);
        }

        // Return a response indicating success
        return response()->json(['message' => 'Profile updated successfully!', 'user' => $user->fresh(), 'profile' => $user->profile], 200);
    } catch (\Exception $e) {
        // Return detailed error information
        return response()->json(['error' => $e->getMessage()], 500);
    }
}



    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Delete the user
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }



// Fetch user profile data by user ID
public function show($id)
{
    $user = User::find($id);
    if ($user) {
        return response()->json($user);
    } else {
        return response()->json(['error' => 'User not found'], 404);
    }
}

// Update user profile data by user ID
public function update(Request $request, $id)
{
    $user = User::find($id);
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    $validated = $request->validate([
        'email' => 'required|email',
        'full_name' => 'required|string',
        'address' => 'nullable|string',
        'age' => 'nullable|integer',
        'gender' => 'nullable|string',
        'phone_number' => 'nullable|string',
        'membership_id' => 'nullable|integer',
    ]);

    $user->update($validated);
    return response()->json(['message' => 'Profile updated successfully']);
}   public function updatePassword(Request $request, $userId)
{
    // Validate the incoming request
    $request->validate([
        'current_password' => 'required|string',
        'new_password' => 'required|string|min:8|confirmed', // Confirmed requires a 'new_password_confirmation' field
    ]);

    // Fetch the user instance from the database using the provided userId
    $user = User::find($userId);

    // Ensure user exists
    if (!$user) {
        return response()->json(['error' => 'User not found.'], 404);
    }

    // Check if the current password is correct
    if (!Hash::check($request->current_password, $user->password)) {
        throw ValidationException::withMessages([
            'current_password' => ['The provided password does not match your current password.'],
        ]);
    }

    // Update the password
    $user->password = Hash::make($request->new_password);

    // Attempt to save the user
    try {
        $user->save(); // Save the updated password
        return response()->json(['message' => 'Password updated successfully.'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Could not update password.'], 500);
    }
}

}












