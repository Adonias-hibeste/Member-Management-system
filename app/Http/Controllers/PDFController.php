<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function generatePdf($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $data = [
            'title' => 'Payment Receipt',
            'date' => date('m/d/Y'),
            'payment' => [$payment]
        ];

        $pdf = Pdf::loadView('user.generate-pdf', $data);
        return $pdf->download('membership-payment.pdf');
    }
}
