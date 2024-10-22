<?php

namespace App\Http\Controllers;

use App\Models\MembershipPayment;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Profile;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class PaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            Log::error('User not authenticated.');
            return redirect()->back()->with('error', 'User not authenticated.');
        }

        $profile = Profile::with('membership')->where('user_id', $user->id)->first();

        // Check if profile exists
        if ($profile) {
            return view('User.membership_payment.index', [
                'profile' => $profile,
                'amount' => $profile->membership->price, // Get the price from the membership
            ]);
        }

        // Handle case where profile does not exist (optional)
        return redirect()->back()->with('error', 'Profile not found.');
    }

    public function processPayment(Request $request)
    {

        if (!Auth::check()) {
            Log::error('User not authenticated during payment process.');
            return redirect()->route('login')->with('error', 'You need to be logged in to make a payment.');
        }

        $client = new Client();

        $tx_ref = 'TX_' . uniqid() . '_' . Auth::id() . '_' . time(); // Ensure unique tx_ref

        // Store tx_ref in session for later use in callback
        Log::info('Generated tx_ref: ' . $tx_ref);
        session(['tx_ref' => $tx_ref]);

        // Chapa API endpoint for initiating payment
        $url = 'https://api.chapa.co/v1/transaction/initialize';
        $chapaSecretKey = 'CHASECK_TEST-apCgo8j5B4cpFmtlgV1NOAgpqp3PksVz';

        // Prepare the data for Chapa API
        $data = [
            'amount' => $request->input('amount'),
            'currency' => 'ETB',
            'email' => $request->user()->email,
            'first_name' => $request->user()->full_name,
            'tx_ref' => $tx_ref,
            'callback_url' => route('user.membershipPayment.callback'),
            'customization' => [
                'title' => 'Payment',
                'description' => 'Service payment description',
            ],
        ];

        // Initialize payment
        $response = $client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $chapaSecretKey,
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $responseBody = json_decode($response->getBody(), true);

        if ($responseBody['status'] === 'success') {
            return redirect($responseBody['data']['checkout_url']);
        } else {
            return redirect()->back()->with('error', 'Payment initiation failed.');
        }
    }

    public function paymentCallback(Request $request)
{
    $chapaSecretKey = 'CHASECK_TEST-apCgo8j5B4cpFmtlgV1NOAgpqp3PksVz';

    Log::info('Received payment callback data', ['request_data' => $request->all()]);

    $trx_ref = $request->input('trx_ref');
    Log::info('Received payment callback', ['trx_ref' => $trx_ref]);

    if (!$trx_ref) {
        return redirect()->route('user.membership.payment')->with('error', 'Transaction reference missing.');
    }

    Log::info('Session tx_ref: ' . session('tx_ref'));

    $parts = explode('_', $trx_ref);
    if (!isset($parts[2])) {
        Log::error('Invalid trx_ref format: ' . $trx_ref);
        return redirect()->route('user.membership.payment')->with('error', 'Invalid transaction reference.');
    }

    $userId = $parts[2];
    Log::info('Extracted userId: ' . $userId);

    $user = User::find($userId);
    if (!$user) {
        Log::error('User not found for trx_ref: ' . $trx_ref);
        return redirect()->route('user.membership.payment')->with('error', 'User not found.');
    }

    $response = Http::withToken($chapaSecretKey)->get('https://api.chapa.co/v1/transaction/verify/' . $trx_ref);
    Log::info('Payment verification response: ', ['response' => $response->body()]);

    if ($response->successful()) {
        $paymentData = $response->json();
        Log::info('Payment verification successful: ', $paymentData);

        if ($paymentData['data']['status'] == 'success') {
            Log::info('Payment method: ' . ($paymentData['data']['method'] ?? 'N/A'));

            // Store payment details
            $this->storePaymentDetails($paymentData, $user->id);

            // Update membership status and extend membership
            $this->updateMembership($userId, $paymentData['data']['amount']);

            session()->forget('tx_ref');
            return redirect()->route('user.membership.payment')->with('message', 'Payment successful');
        } else {
            Log::error('Payment verification status not successful: ' . $paymentData['data']['status']);
        }
    } else {
        Log::error('Payment verification API call failed', ['response' => $response->body()]);
    }

    return redirect()->route('user.membership.payment')->with('error', 'Payment verification failed.');
}

protected function updateMembership($userId, $amount)
{
    // Find the user's profile
    $profile = Profile::where('user_id', $userId)->first();
    if ($profile) {
        // Update payment status and extend membership
        $profile->member_payment_status = 'paid'; // Update payment status to active
        $profile->membership_endDate = now()->addMonth(); // Extend membership by one month
        $profile->save();

        Log::info('Membership status updated for user ID: ' . $userId);
    } else {
        Log::error('Profile not found for user ID: ' . $userId);
    }
}

    protected function storePaymentDetails(array $paymentData, $userId)
{
    // Example of how to handle the payment method safely
    $paymentMethod = $paymentData['data']['payment_method'] ?? 'N/A'; // Default if not set
    Log::info('Storing payment details for user ID: ' . $userId);

    // Store payment details in the database
    MembershipPayment::create([
        'user_id' => $userId,
        'tx_ref' => $paymentData['data']['tx_ref'],
        'amount' => $paymentData['data']['amount'],
        'status' => $paymentData['status'],
        'payment_method' => $paymentMethod,
   //   'payment_date' => now(),
    ]);
}

    public function processPaymentapp(Request $request)
    {
        // Validate the user ID passed from the Flutter app
        $user = User::find($request->input('user_id'));

        if (!$user) {
            Log::error('User not found during payment process.');
            return response()->json(['error' => 'Invalid user ID.'], 401);
        }

        $client = new Client();

        $tx_ref = 'TX_' . uniqid() . '_' . $user->id . '_' . time(); // Ensure unique tx_ref

        // Store tx_ref in session for later use in callback
        Log::info('Generated tx_ref: ' . $tx_ref);
        session(['tx_ref' => $tx_ref]);

        // Chapa API endpoint for initiating payment
        $url = 'https://api.chapa.co/v1/transaction/initialize';
        $chapaSecretKey = 'CHASECK_TEST-apCgo8j5B4cpFmtlgV1NOAgpqp3PksVz';

        // Prepare the data for Chapa API
        $data = [
            'amount' => $request->input('amount'),
            'currency' => 'ETB',
            'email' => $user->email,
            'first_name' => $user->full_name,
            'tx_ref' => $tx_ref,
            'callback_url' => route('user.membershipPayment.callback'),
            'customization' => [
                'title' => 'Payment',
                'description' => 'Service payment description',
            ],
        ];

        // Initialize payment
        $response = $client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $chapaSecretKey,
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $responseBody = json_decode($response->getBody(), true);

        if ($responseBody['status'] === 'success') {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'checkout_url' => $responseBody['data']['checkout_url']
                ]
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment initiation failed.'
            ], 400);
        }
    }



}
