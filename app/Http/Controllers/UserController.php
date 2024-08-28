<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EventRegister;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function Userdashboard(){
        $event_registers = EventRegister::count();
        $payment_made = Payment::count();
        $registered_member = User::count();

        return view ('user.userdashboard',compact('event_registers', 'payment_made', 'registered_member'));
    }
    public function UserLogout(Request $request){
        Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/admin/login');
     }
}
