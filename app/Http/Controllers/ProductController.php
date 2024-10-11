<?php
namespace App\Http\Controllers;

use App\Models\Catagory;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function edit($id){
        $product=Product::with(['images','catagory'])->find($id);
        $catagories=Catagory::all();

        return view('Admin.products.edit',compact('product','catagories'));
    }

    public function update(Request $request, $id)
{
    // Validate the request
    $validatedData = $request->validate([
        'Product_name' => 'required|string|max:255',
        'catagories' => 'required|exists:catagories,id', // Adjust based on your category model
        'description' => 'nullable|string',
        'quantity' => 'required|integer|min:0',
        'unit_price' => 'required|numeric|min:0',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max size as needed
        'current_images.*' => 'nullable|string', // Assuming these are paths or IDs
    ]);

    // Find the product
    $product = Product::find($id);

    // Update product details
    $product->name = $validatedData['Product_name'];
    $product->catagory_id = $validatedData['catagories'];
    $product->description = $validatedData['description'];
    $product->quantity = $validatedData['quantity'];
    $product->unit_price = $validatedData['unit_price'];
    $product->save();

    // Handle current images removal
    $currentImages = $request->input('current_images', []);

    foreach ($product->images as $image) {
        if (!in_array($image->image, $currentImages)) {
            // Delete image from storage
            $imagePath = public_path('uploads/products/' . $image->image);

            // Check if the file exists before attempting to delete it
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the file
            }
            $image->delete();
        }
    }

    // Handle new images upload
    if ($request->hasFile('images')) {
  foreach($request->file('images') as $image){
            $filename=time(). "_". uniqid() .".". $image->getClientOriginalExtension();
           $image->move(public_path('uploads/products'),$filename);

           Image::create([
               'product_id'=>$product->id,
               'image'=>$filename
           ]);
        }
    }

    return redirect()->route('admin.viewProducts')->with('success', 'Product updated successfully!');
}

public function destroy($id){

        // Find the product with its associated images
        $product = Product::with('images')->find($id);

        if (!$product) {
            return redirect()->route('admin.viewProducts')->with('error', 'Product not found!');
        }

        // Delete associated images from storage
        foreach ($product->images as $image) {

            $imagePath = public_path('uploads/products/' . $image->image);

            // Check if the file exists before attempting to delete it
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the file
            }
        }


        $product->delete();

        return redirect()->route('admin.viewProducts')->with('success', 'Product deleted successfully!');
    }

    // Ensure this method is correctly defined
    public function productapp(){
        $products = Product::with('catagory', 'images')->get();
        return response()->json($products);
    }
}

