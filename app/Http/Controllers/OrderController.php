<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
   public function index(){
    $orders=Order::all();
    $users=User::all();

    return view('Admin.order.index',compact('orders','users'));

   }
   public function make_order(){
    $products=Product::with('images')->get();

    return view('User.make_order',compact('products'));
   }

   public function checkout(Request $request)
{
    try {
        // Ensure the user is authenticated
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Get all cart items for the user
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();
        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        // Calculate the total amount for the order
        $totalAmount = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->unit_price;
        });

        // Create the order
        $order = Order::create([
            'member_id' => $userId,
            'order_date' => now(),
            'payment_status' => 'Pending',
            'total_amount' => $totalAmount,
        ]);

        // Loop through cart items to create order items and update stock
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;

            // Ensure product has enough stock
            if ($product->quantity < $cartItem->quantity) {
                return response()->json(['error' => 'Not enough stock for product: ' . $product->name], 400);
            }

            // Create order item
            OrderItem::create([
                'product_id' => $product->id,
                'order_id' => $order->id,
                'quantity' => $cartItem->quantity,
                'payment_status' => 'Pending',
                'price' => $product->unit_price,
            ]);

            // Deduct the product stock
            $product->decrement('quantity', $cartItem->quantity);
        }

        // Clear the cart after checkout
        Cart::where('user_id', $userId)->delete();

        return response()->json(['message' => 'Order placed successfully', 'order_id' => $order->id]);
    } catch (\Exception $e) {
        // Log detailed error message
        Log::error('Checkout error: ' . $e->getMessage());
        Log::error('Stack Trace: ' . $e->getTraceAsString());

        // Return error response to the frontend
        return response()->json(['error' => 'An error occurred during checkout. Please try again later.'], 500);
    }
}



}
