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
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
   public function index(){
    $orders=Order::with('user')->get();


    return view('Admin.order.index',compact('orders'));

   }
   public function make_order(){

    $products=Product::with('images')->get();

    return view('User.make_order',compact('products'));
   }

   public function checkout(Request $request)
{
    DB::beginTransaction();
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
            Log::info('Creating order item for product ID: ' . $cartItem->product->id . ' in order ID: ' . $order->id);

            // Create order item
            OrderItem::create([
                'product_id' => $product->id,
                'order_id' => $order->id,
                'quantity' => $cartItem->quantity,
                'payment_status' => 'Pending',
                'price' => $product->unit_price,
            ]);
            Log::info('Creating order item for product ID: ' . $cartItem->product->id . ' in order ID: ' . $order->id);


            // Deduct the product stock
            $product->decrement('quantity', $cartItem->quantity);
        }


        // Clear the cart after checkout
        Cart::where('user_id', $userId)->delete();
        DB::commit();

        return response()->json(['message' => 'Order placed successfully', 'order_id' => $order->id]);
    } catch (\Exception $e) {
        // Log detailed error message
        DB::rollback(); // Rollback transaction if there is an error
        Log::error('Checkout error: ' . $e->getMessage());
        Log::error('Stack Trace: ' . $e->getTraceAsString());

        // Return error response to the frontend
        return response()->json(['error' => 'An error occurred during checkout. Please try again later.'], 500);
    }
}

public function show($id)
{
    $order = Order::with('order_item.product')->find($id);
    return view('Admin.order.show', compact('order'));
}

public function update(Request $request, $id)
{
    //  $request->validate([
    //     'payment_status' => 'required|string', // Ensure payment_status is present and a string
    // ]);
    //dd( $request->all());
    $order = Order::find($id);
    $order->payment_status = $request->input('payment_status');
    $order->save();

    return redirect()->back()->with('message', 'Payment status updated successfully');
}

public function destroy($id){

    $order=Order::find($id);
    $order->delete();

    return redirect()->back()->with('message', 'Order deleted successfully.');
}



}
