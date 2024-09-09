<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class AdminPaymentController extends Controller
{
    public function showPaymentForm()
    {
        return view('Admin.payment');
    }

        public function processPayment(Request $request)
    {
        $request->validate([
            'memberName' => 'required|string|max:255',
            'membershipType' => 'required|string',
            'paymentMethod' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        $payment = Payment::create([
            'member_name' => $request->memberName,
            'membership_type' => $request->membershipType,
            'payment_method' => $request->paymentMethod,
            'phone_number' => $request->phone_number,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'amount' => $request->amount,
        ]);

        return view('admin.payment')->with([
            'success' => 'Payment processed successfully!',
            'paymentId' => $payment->id,
        ]);

    }
    

}
