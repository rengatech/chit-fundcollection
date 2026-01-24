<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PaymentReceiptController extends Controller
{
    public function generate(Payment $payment)
    {
        $pdf = Pdf::loadView('pdf.receipt', compact('payment'));
        
        return $pdf->stream("receipt-{$payment->receipt_number}.pdf");
    }
}