<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ImageFormRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileFormRequest;
use Illuminate\Support\Facades\Validator;


class MemberController extends Controller
{

public function Profile(){
    $profiles=Profile::all();
    return view('user.profile',compact('profiles'));
}
public function Create(){
    return view('user.createprofile');
}
public function Store(ProfileFormRequest $request){

   $data = $request -> validated();

    $profile = new Profile;
    $profile->name = $data['name'];

    $profile->full_address = $data['full_address'];
    if($request->hasfile('image')){
        $file = $request->file('image');
        $filename = time(). "." .$file->getClientOriginalExtension();

        $file->move('uploads/profiles', $filename);
        $profile->image = 'uploads/profiles/'.$filename;
    }
    $profile->dob = $data['dob'];
    $profile->place_of_birth = $data['place_of_birth'];
    $profile->nationality = $data['nationality'];

    $profile->gender = $data['gender'];
    $profile->email = $data['email'];
    $profile->phone_number = $data['phone_number'];
    $profile->password = $data['password'];
    $profile->membership_type = $data['membership_type'];


    $profile->save();

    return redirect()->route('user.profile')->with('message', 'Profile added successfully');
}
    public function Edit($profile_id){
        $profiles=Profile::find($profile_id);
        return view('user.edit',compact('profiles'));
    }

    public function Update(ProfileFormRequest $request, $profile_id){
        $data = $request -> validated();

    $profile = Profile::find($profile_id);
    $profile->name = $data['name'];

    $profile->full_address = $data['full_address'];
    if($request->hasfile('image')){
        $file = $request->file('image');
        $filename = time(). "." .$file->getClientOriginalExtension();

        $file->move('uploads/profiles', $filename);
        $profile->image = 'uploads/profiles/'.$filename;
    }
    $profile->dob = $data['dob'];
    $profile->place_of_birth = $data['place_of_birth'];
    $profile->nationality = $data['nationality'];

    $profile->gender = $data['gender'];
    $profile->email = $data['email'];
    $profile->phone_number = $data['phone_number'];
    $profile->password = $data['password'];
    $profile->membership_type = $data['membership_type'];



    $profile->update();

    return redirect()->route('user.profile')->with('message', 'Profile updated successfully');
    }
    public function Destroy($profile_id){
        $profiles=Profile::find($profile_id);
        $profiles->delete();
        return redirect()->route('user.profile')->with('message', 'Profile Deleted successfully');
    }
    public function register(ProfileFormRequest $request)
    {
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('uploads/profiles'), $imageName);

        $userData = [
            'name' => $request->name,
            'full_address' => $request->full_address,
            'dob' => $request->dob,
            'place_of_birth' => $request->place_of_birth,
            'image' => $imageName,
            'nationality' => $request->nationality,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'membership_type' => $request->membership_type,
        ];

        $user = Profile::create($userData);
        $token = $user->createToken('membermanagmentapp')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
        ], 201);
    }
    public function Registerapp(Request $request)
{

    $request->validate([
        'name' => 'required|string',
        'full_address' => 'required',
        'dob' => 'required',
        'place_of_birth' => 'required',
        'nationality' => 'required',
        'gender' => 'required',
        'email' => 'required|email',
        'phone_number' => 'required',
        'password' => 'required|min:6',
        'membership_type' => 'required',
    ]);

    // Save the user data
    $profile = new Profile();
    $profile->name = $request->name;
    $profile->full_address = $request->full_address;
    $profile->dob = $request->dob;
    $profile->place_of_birth = $request->place_of_birth;
    $profile->nationality = $request->nationality;
    $profile->gender = $request->gender;
    $profile->email = $request->email;
    $profile->phone_number = $request->phone_number;
    $profile->password = bcrypt($request->password);
    $profile->membership_type = $request->membership_type;

    // Handle image upload


    $profile->save();

    return response()->json(['message' => 'User registered successfully', 'user' => $profile], 201);
}




    public function Loginapp(LoginRequest $request)
    {
        $request->validated();
        $user = Profile::whereEmail($request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response(['message' => 'Invalid credentials'], 422);
        }

        // Log successful authentication
        Log::info('User logged in successfully', ['user_id' => $user->id, 'email' => $user->email]);

        // Generate a token or perform any other actions needed upon successful login
        $token = $user->createToken('membermanagmentapp')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
        ], 200);
    }



    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();
        if ($user) {
            // Revoke the token that was used to authenticate the current request
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Successfully logged out'], 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }


    public function getProfile()
    {
        $userId = Auth::guard('auth:api')->id(); // Get the logged-in user's ID
        Log::info('User ID from Auth: ' . $userId); // Log the user ID

        if (!$userId) {
            Log::info('User is not authenticated');
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $profile = Profile::where('id', $userId)->first(); // Fetch the profile details using id

        if ($profile) {
            Log::info('Profile found for user ID: ' . $userId); // Log if profile is found
            return response()->json([
                'name' => $profile->name,
                'email' => $profile->email,
                'phone_number' => $profile->phone_number,
                'membership_type' => $profile->membership_type,
            ]);
        } else {
            Log::info('Profile not found for user ID: ' . $userId); // Log if profile not found
            return response()->json(['error' => 'Profile not found'], 404);
        }
    }


}
