<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AdminForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('admin.forgot');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'name' => 'required|exists:admins,name',
            'password' => 'required|string|confirmed',
        ]);

        $admin = Admin::where('name', $request->name)->first();

        if (!$admin) {
            return back()->withErrors(['name' => 'The provided name does not exist.']);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('admin.login')->with('status', 'Password has been reset!');
    }
}
