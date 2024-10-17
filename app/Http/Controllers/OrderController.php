<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\PendingOrder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class OrderController extends Controller
{
   public function index(){
    $orders=Order::with('user')->get();


    return view('Admin.order.index',compact('orders'));

   }
   public function make_order(){

    $products=Product::with('images')->get();

    return view('User.purchase.make_order',compact('products'));
   }

   public function purchaseOrderDetail(){
    return view('User.purchase.purchaseOrderDetails');
   }




   public function checkout(Request $request)
   {
       Log::info('Checkout method triggered', ['request' => $request->all()]);

       // Validate request data
       $request->validate([
           'name' => "required|string",
           'email' => "required|email",
           'phone' => 'required|digits:10',
           'city' => 'required|string|max:255',
           'woreda' => 'required|string|max:255',
           'house_no' => 'required|string|max:255'
       ]);

       // Ensure user is authenticated
       $userId = Auth::id();
       if (!$userId) {
           return response()->json(['error' => 'User not authenticated'], 401);
       }

       // Get cart items
       $cartItems = Cart::where('user_id', $userId)->with('product')->get();
       if ($cartItems->isEmpty()) {
           return response()->json(['error' => 'Cart is empty'], 400);
       }

       // Calculate total amount
       $totalAmount = $cartItems->sum(function ($cartItem) {
           return $cartItem->quantity * $cartItem->product->unit_price;
       });

       $tx_ref = 'TX_' . uniqid() . '_' . Auth::id() . '_' . time(); // Unique transaction reference

       // Chapa API endpoint for initiating payment
       $url = 'https://api.chapa.co/v1/transaction/initialize';
       $chapaSecretKey = 'CHASECK_TEST-apCgo8j5B4cpFmtlgV1NOAgpqp3PksVz';

       // Prepare data for Chapa API
       $data = [
           'amount' => $totalAmount,
           'currency' => 'ETB',
           'email' => $request->email,
           'first_name' => $request->name,
           'tx_ref' => $tx_ref,
           'callback_url' => route('order.payment.callback', ['tx_ref' => $tx_ref]),
           'customization' => [
               'title' => 'Order Payment',
               'description' => 'Payment for your order',
           ],
       ];

       $client = new Client();
       $response = $client->post($url, [
           'headers' => [
               'Authorization' => 'Bearer ' . $chapaSecretKey,
               'Content-Type' => 'application/json',
           ],
           'json' => $data,
       ]);

       $responseBody = json_decode($response->getBody(), true);

       if ($responseBody['status'] === 'success') {
           // Store checkout details in database
           $pending_order =PendingOrder ::create([
               'user_id' => $userId,
               'tx_ref' => $tx_ref,
               'total_amount' => $totalAmount,
               'customer_info' => $request->only(['name', 'email', 'phone', 'city', 'woreda', 'house_no']),
           ]);

           Log::info('pending_order details saved in database', ['pending_order' => $pending_order]);

           // Redirect to Chapa's payment page
           return redirect($responseBody['data']['checkout_url']);
       } else {
           return redirect()->back()->with('error', 'Payment initiation failed.');
       }
   }


   public function paymentCallback(Request $request)
   {
       $tx_ref = $request->input('tx_ref'); // Transaction reference from Chapa
       Log::info('Payment callback received', ['tx_ref' => $tx_ref]);

       // Chapa Secret Key
       $chapaSecretKey = 'CHASECK_TEST-apCgo8j5B4cpFmtlgV1NOAgpqp3PksVz';

       // Verify payment with Chapa
       $response = Http::withToken($chapaSecretKey)->get('https://api.chapa.co/v1/transaction/verify/' . $tx_ref);
       Log::info('Payment verification response: ', ['response' => $response->body()]);

       if ($response->successful()) {
           $paymentData = $response->json();

           if ($paymentData['status'] === 'success') {
               // Retrieve checkout details from the database
               $pending_order = PendingOrder::where('tx_ref', $tx_ref)->first();

               if ($pending_order) {
                   DB::beginTransaction();

                   try {
                       // Create the order
                       $order = Order::create([
                           'member_id' => $pending_order->user_id,
                           'tx_ref'=>$pending_order->tx_ref,
                           'order_date' => now(),
                           'payment_status' => 'Paid',
                           'total_amount' => $pending_order->total_amount,
                       ]);

                       Log::info('Order created successfully', ['order' => $order]);

                       // Create the order details
                       OrderDetail::create([
                           'order_id' => $order->id,
                           'name' => $pending_order->customer_info['name'],
                           'email' => $pending_order->customer_info['email'],
                           'phone' => $pending_order->customer_info['phone'],
                           'city' => $pending_order->customer_info['city'],
                           'woreda' => $pending_order->customer_info['woreda'],
                           'house_no' => $pending_order->customer_info['house_no'],
                       ]);

                       // Loop through cart items to create order items
                       $cartItems = Cart::where('user_id', $pending_order->user_id)->get();
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
                               'payment_status' => 'Paid',
                               'price' => $product->unit_price,
                           ]);

                           // Deduct product stock
                           $product->decrement('quantity', $cartItem->quantity);
                       }

                       // Clear the cart
                       Cart::where('user_id', $pending_order->user_id)->delete();

                       DB::commit();
                       return redirect()->route('user.makeOrder')->with('message', 'Payment successful, your order has been placed.');
                   } catch (\Exception $e) {
                       DB::rollback();
                       Log::error('Order creation error: ' . $e->getMessage());
                       return redirect()->route('user.makeOrder')->with('error', 'An error occurred while placing your order.');
                   }
               } else {
                   Log::error('pending_order not found for tx_ref: ' . $tx_ref);
                   return redirect()->route('user.makeOrder')->with('error', 'Transaction reference mismatch or pending_order details not found.');
               }
           }
       }

       return redirect()->route('user.makeOrder')->with('error', 'Payment verification failed.');
   }


public function show($id)
{
    $order = Order::with('order_item.product')->find($id);
    return view('Admin.order.show', compact('order'));
}

// public function update(Request $request, $id)
// {
//     //  $request->validate([
//     //     'payment_status' => 'required|string', // Ensure payment_status is present and a string
//     // ]);
//     //dd( $request->all());
//     $order = Order::find($id);
//     $order->payment_status = $request->input('payment_status');
//     $order->save();

//     return redirect()->back()->with('message', 'Payment status updated successfully');
// }

public function destroy($id){

    $order=Order::find($id);
    $order->delete();

    return redirect()->back()->with('message', 'Order deleted successfully.');
}



}
