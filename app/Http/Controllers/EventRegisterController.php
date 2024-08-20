<?php

namespace App\Http\Controllers;


use App\Models\EventRegister;
use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\EventRegister;
use Illuminate\Http\Request;

class EventRegisterController extends Controller
{

    public function showForm()
    {
        return view('user.eventRegister');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'event' => 'required|exists:events,id',
        ]);

        EventRegister::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'event_id' => $request->event,
        ]);

        return redirect()->back()->with('success', 'You have successfully registered for the event!');
    }
}
