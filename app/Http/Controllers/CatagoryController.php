<?php

namespace App\Http\Controllers;

use App\Models\Catagory;
use Illuminate\Http\Request;
namespace App\Http\Controllers;

use App\Models\Catagory;
use Illuminate\Http\Request;

class CatagoryController extends Controller
{
    public function index(){
        $catagories = Catagory::all();
        return view('Admin.catagories.index', compact('catagories'));
    }

    public function create(){
        return view('Admin.catagories.create');
    }

    public function store(Request $request){
        $request->validate([
            'catagory_name' => 'required|string|max:100',
            'description' => 'required|max:1000'
        ]);

        Catagory::create([
            'name' => $request->catagory_name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.catagories')->with('success', 'Catagory created successfully');
    }

    public function edit($id){
        $catagory=Catagory::find($id);
        return view('Admin.catagories.edit',compact('catagory'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'catagory_name'=>'required|string|max:255',
            'description'=>'required|max:1000',
        ]);

        $catagory=Catagory::find($id);

        $catagory->name=$request->catagory_name;
        $catagory->	description	=$request->description;

        $catagory->save();

        return redirect()->route('admin.catagories')->with('sucess','catagory updated successfully');
    }

    public function destroy($id){
        $catagory=Catagory::find($id);
        $catagory->delete();
        return redirect()->route('admin.catagories')->with('sucess','catagory deleted sucessfully');
    }

    // Ensure this method is correctly defined
    public function categoryapp(){
        $catagories = Catagory::all();
        return response()->json($catagories);

    }
}
