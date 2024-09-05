<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EventRegister;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function Userdashboard(){
        $event_registers = EventRegister::count();

        return view ('user.userdashboard',compact('event_registers'));
    }
    public function UserLogout(Request $request){
        Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/admin/login');
     }
}
