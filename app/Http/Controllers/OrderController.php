<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
   public function index(){
    $orders=Order::all();
    $users=User::all();

    return view('Admin.order.index',compact('orders','users'));

   }
   public function make_order(){
    $products=Product::with('images')->get();

    return view('Admin.order.make_order',compact('products'));
   }

//    public function addToCart(Request $request)
//    {
//        $product = Product::find($request->product_id);

//        // Retrieve the cart from the session (or initialize an empty cart)
//        $cart = session()->get('cart', []);

//        // Check if the product is already in the cart
//        if (isset($cart[$product->id])) {
//            // Check if we can increase the quantity
//            if ($cart[$product->id]['quantity'] < $product->quantity) {
//                // Increase the quantity in the cart
//                $cart[$product->id]['quantity']++;
//            } else {
//                return response()->json(['message' => 'Maximum quantity reached'], 400);
//            }
//        } else {
//            // Add new product to the cart
//            $cart[$product->id] = [
//                'id' => $product->id,
//                "name" => $product->name,
//                "quantity" => 1,
//                "unit_price" => $product->unit_price,
//                "image" => $product->images->first()->image
//            ];
//        }

//        // Save the updated cart back into the session
//        session()->put('cart', $cart);
//       // dd(session()->get('cart'));
//        // Return a response with the cart and a message
//        return response()->json([
//            'message' => 'Product added to cart',
//            'cartCount' => count($cart),
//            'cart' => $cart
//         ]);
//    }


    // Display the cart contents
    // public function showCart(){
    //     // Get the cart from the session
    //  try {
    //     $cart = session()->get('cart', []);

    //     // Iterate through each item and calculate the total price
    //     foreach ($cart as $key => $item) {
    //         if (!isset($item['quantity']) || !isset($item['unit_price'])) {
    //             Log::error("Cart item missing data: " . json_encode($item));
    //             throw new \Exception("Cart item data is incomplete.");
    //         }

    //         $cart[$key]['total_price'] = $item['quantity'] * $item['unit_price'];
    //     }

    //     // Put the updated cart back into the session (optional if you need to store total price in session)
    //     session()->put('cart', $cart);

    //     // Return the cart as JSON
    //     return response()->json($cart);
    //     }
    //     catch (\Exception $e) {
    //         // Log the error and return a 500 status with the error message
    //         Log::error('Error in showCart: ' . $e->getMessage());
    //         return response()->json(['error' => 'Something went wrong'], 500);
    //     }
    // }


    // public function removeFromCart(Request $request)
    // {
    //     $productId = $request->product_id;

    //     // Retrieve the cart from the session
    //     $cart = session()->get('cart', []);

    //     // Check if the product exists in the cart
    //     if (isset($cart[$productId])) {
    //         // Decrease the quantity by 1
    //         $cart[$productId]['quantity']--;

    //         // If quantity reaches 0, remove the product from the cart
    //         if ($cart[$productId]['quantity'] == 0) {
    //             unset($cart[$productId]);
    //         }

    //         // Update the cart in the session
    //         session()->put('cart', $cart);
    //     }

    //     // Return the updated cart
    //     return response()->json([
    //         'message' => 'Product updated in cart',
    //         'cartCount' => count($cart),
    //         'cart' => $cart
    //     ]);
    // }



}
