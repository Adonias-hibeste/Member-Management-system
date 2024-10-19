<?php
namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index(){
        $memberships = Membership::all();
        return view('Admin.membership.index', compact('memberships'));
    }

    public function create(){
        return view('Admin.membership.create');
    }

    public function store(Request $request){
        $request->validate([
            'membership_name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        // Create a new membership
        Membership::create([
            'name' => $request->membership_name,

            'price' => $request->price,
        ]);

        return redirect()->route('admin.membership.index')->with('success', 'Membership added successfully!');
    }


    public function edit($id){
        $membership=Membership::find($id);
        return view('Admin.membership.edit',compact('membership'));

    }

    public function update(Request $request, $id){

        $request->validate([
            'membership_name'=>'required|max:255',
            'price'=>'required|numeric'
        ]);

        $membership=Membership::find($id);

        $membership->name=$request->membership_name;
        $membership->price=$request->price;

        $membership->save();

        return redirect()->route('admin.membership.index')->with('sucess','membership type updated sucessfully');


    }

    public function destroy($id){
        $membership=Membership::find($id);

        $membership->delete();

        return redirect()->route('admin.membership.index')->with('success','memberhip type deleted sucessfully');
    }

    // Ensure this method is correctly defined
    public function getMemberships()
    {
        $memberships = Membership::all();
        return response()->json($memberships);
    }
}
