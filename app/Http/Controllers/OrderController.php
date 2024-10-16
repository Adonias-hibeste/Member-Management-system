<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderItem;
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
       // Validate the incoming request data
       $request->validate([
           'name' => "required|string",
           'email' => "required|email",
           'phone' => 'required|digits:10',
           'city' => 'required|string|max:255',
           'woreda' => 'required|string|max:255',
           'house_no' => 'required|string|max:255'
       ]);

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
       $client = new Client();

       $tx_ref = 'TX_' . uniqid() . '_' . Auth::id() . '_' . time(); // Ensure unique tx_ref

       // Store tx_ref in session for later use in callback
       Log::info('Generated tx_ref: ' . $tx_ref);


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

       // Send the API request to Chapa
       $response = $client->post($url, [
        'headers' => [
            'Authorization' => 'Bearer ' . $chapaSecretKey,
            'Content-Type' => 'application/json',
        ],
        'json' => $data,
    ]);

    $responseBody = json_decode($response->getBody(), true);


       if ($responseBody['status'] === 'success') {
           // Store checkout details in session to use after payment confirmation
           session(['checkout_details' => [
               'user_id' => $userId,
               'cart_items' => $cartItems,
               'total_amount' => $totalAmount,
               'customer_info' => $request->only(['name', 'email', 'phone', 'city', 'woreda', 'house_no']),
               'tx_ref' => $tx_ref,
           ]]);

           // Redirect to Chapa's payment page
           return redirect($responseBody['data']['checkout_url']);
       } else {
           return redirect()->back()->with('error', 'Payment initiation failed.');
       }
   }

   public function paymentCallback(Request $request)
   {
       $tx_ref = $request->input('tx_ref'); // Transaction reference from Chapa

       // Log the session data
       Log::info('Session data on callback:', ['session' => session()->all()]);

       // Verify the payment with Chapa
       $response = Http::withToken(env('CHAPA_SECRET_KEY'))->get('https://api.chapa.co/v1/transaction/verify/' . $tx_ref);

       if ($response->successful()) {
           $paymentData = $response->json();

           if ($paymentData['status'] == 'success') {
               $checkoutDetails = session('checkout_details');
               Log::info('Checkout details retrieved from session', ['checkoutDetails' => $checkoutDetails]);

               // Check for authenticated user
               $userId = Auth::id();
               Log::info('Authenticated user ID:', ['userId' => $userId]);

               if ($userId && $checkoutDetails['tx_ref'] === $tx_ref) {
                   DB::beginTransaction();

                   try {
                       // Create the order
                       $order = Order::create([
                           'member_id' => $checkoutDetails['user_id'],
                           'order_date' => now(),
                           'payment_status' => 'Paid',
                           'total_amount' => $checkoutDetails['total_amount'],
                       ]);

                       // Continue with order details and items...
                       // ...

                       DB::commit();
                       return redirect()->route('order.success')->with('message', 'Payment successful, your order has been placed.');
                   } catch (\Exception $e) {
                       DB::rollback();
                       Log::error('Order creation error: ' . $e->getMessage());
                       return redirect()->route('order.failed')->with('error', 'An error occurred while placing your order.');
                   }
               } else {
                   Log::error('User not authenticated or transaction reference mismatch.');
                   return redirect()->route('order.failed')->with('error', 'User not authenticated or transaction reference mismatch.');
               }
           }
       }

       return redirect()->route('order.failed')->with('error', 'Payment verification failed.');
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
