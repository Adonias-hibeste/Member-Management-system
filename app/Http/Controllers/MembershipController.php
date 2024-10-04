<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index(){
        $memberships=Membership::all();

        return view('Admin.membership.index',compact('memberships'));
    }
    public function create(){
        return view('Admin.membership.create');
    }

    public function store(Request $request){
        $request->validate([
            'membership_name' => 'required|string|max:255',
            'duration' => 'required|string|max:50',
            'price' => 'required|numeric',
        ]);

        // Create a new membership
        Membership::create([
            'name' => $request->membership_name,
            'duration' => $request->duration,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.membership.index')->with('success', 'Membership added successfully!');
    }
}