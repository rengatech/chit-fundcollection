<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt - {{ $payment->receipt_number }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; padding: 20px; color: #333; }
        .receipt-box { width: 400px; margin: auto; border: 1px dashed #999; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .title { font-size: 20px; font-weight: bold; margin: 0; }
        .row { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .label { font-weight: bold; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; font-style: italic; }
        .btn-print { display: block; width: 100px; margin: 20px auto; padding: 10px; text-align: center; background: #000; color: #fff; text-decoration: none; border-radius: 5px; }
        @media print { .btn-print { display: none; } }
    </style>
</head>
<body>
    <div class="receipt-box">
        <div class="header">
            <p class="title">DIWALI CHIT FUND</p>
            <p>Payment Receipt</p>
        </div>
        
        <div class="row">
            <span class="label">Receipt #:</span>
            <span>{{ $payment->receipt_number }}</span>
        </div>
        <div class="row">
            <span class="label">Date:</span>
            <span>{{ $payment->payment_date }}</span>
        </div>
        <hr>
        <div class="row">
            <span class="label">Member:</span>
            <span>{{ $payment->user->name }}</span>
        </div>
        <div class="row">
            <span class="label">Enrollment:</span>
            <span>{{ $payment->enrollment->enrollment_number }}</span>
        </div>
        <div class="row">
            <span class="label">Scheme:</span>
            <span>{{ $payment->enrollment->scheme->name }}</span>
        </div>
        <div class="row">
            <span class="label">Installment:</span>
            <span>#{{ $payment->installment_number }}</span>
        </div>
        <hr>
        <div class="row" style="font-size: 18px; font-weight: bold;">
            <span class="label">Amount:</span>
            <span>₹{{ number_format($payment->amount, 2) }}</span>
        </div>
        <div class="row">
            <span class="label">Mode:</span>
            <span>{{ ucfirst($payment->payment_mode) }}</span>
        </div>
        
        <div class="footer">
            <p>Thank you for your payment!</p>
            <p>Paid Installments: {{ $payment->enrollment->paid_installments }} / {{ $payment->enrollment->total_installments }}</p>
        </div>
    </div>

    <a href="#" onclick="window.print();" class="btn-print">Print Now</a>
</body>
</html>
