<?php

namespace App\Http\Controllers;


use App\Models\EventRegister;
use Illuminate\Http\Request;

class EventRegisterController extends Controller
{
    public function showForm()
    {
        $events = EventRegister::all();
        return view('user.eventRegister', compact('events'));
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
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'You have successfully registered for the event!');
    }//
}
