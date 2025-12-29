<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentReceiptController extends Controller
{
    public function generate(Payment $payment)
    {
        $pdf = Pdf::loadView('receipts.payment', compact('payment'));
        return $pdf->download('receipt-' . $payment->receipt_number . '.pdf');
    }
}
