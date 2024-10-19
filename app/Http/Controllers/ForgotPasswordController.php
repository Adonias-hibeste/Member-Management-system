<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function resetPassword()
    {
        return view('admin.forgot');
    }

    public function sendResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
        ]);

        $user=User::where('email',$request->email)->first();

        $newPassword=$this->generatePassword();
        $user->password=bcrypt($newPassword);
        $user->save();

        Mail::to($user->email)->send(new ResetPassword($user,$newPassword));

        return back()->with('success','your password have reseted sucessfully check your email for the new email. ');


    }
    private function generatePassword(){

    return mt_rand(100000,999999);
    }
}
