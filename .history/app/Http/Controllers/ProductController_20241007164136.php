<?php
namespace App\Http\Controllers;

use App\Models\Catagory;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('Admin.products.index', compact('products'));
    }

    public function create(){
        $catagories = Catagory::all();
        return view('Admin.products.create', compact('catagories'));
    }

    public function store(Request $request){
        $request->validate([
            'Product_name' => 'required|string|max:70',
            'description' => 'required|string|max:1000',
            'catagories' => 'required|exists:catagories,id',
            'quantity' => 'required|integer',
            'unit_price' => 'required|numeric',
            'images' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = Product::create([
            'name' => $request->Product_name,
            'description' => $request->description,
            'catagory_id' => $request->catagories,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products'), $filename);

                Image::create([
                    'product_id' => $product->id,
                    'image' => $filename
                ]);
            }
        }

        return redirect()->route('admin.viewProducts')->with('success', 'Product created successfully');
    }

    public function show($id){
        $product = Product::with(['images', 'catagory'])->find($id);
        return view('Admin.products.show', compact('product'));
    }

    // Ensure this method is correctly defined
    public function productapp(){
        $products = Product::with('catagory', 'images')->get();
        return response()->json($products);
    }
}

