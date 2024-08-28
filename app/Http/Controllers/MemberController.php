<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileFormRequest;


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

}
