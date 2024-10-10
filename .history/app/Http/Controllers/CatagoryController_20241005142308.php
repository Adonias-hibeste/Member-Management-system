<?php

namespace App\Http\Controllers;

use App\Models\Catagory;
use Illuminate\Http\Request;

class CatagoryController extends Controller
{
    public function index(){
        $catagories=Catagory::all();

        return view('Admin.catagories.index',compact('catagories'));
    }

    public function create(){
        return view('Admin.catagories.create');
    }

    public function store(Request $request){

        $request->validate([
            'catagory_name'=>'required|string|max:100',
            'description'=>'required|max:1000'
        ]);

        Catagory::create([
            'name'=>$request->catagory_name,
            'description'=>$request->description,
        ]);

        return redirect()->route('admin.catagories')->with('success', 'Catagory created successfully');



    }
}
