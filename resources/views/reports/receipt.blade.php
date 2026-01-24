<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt - {{ $payment->receipt_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #ff6b35;
        }
        .receipt-title {
            font-size: 18px;
            margin: 10px 0;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .details-table th, .details-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .details-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .amount-in-words {
            margin: 20px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 4px solid #ff6b35;
        }
        .footer {
            margin-top: 40px;
            border-top: 1px solid #333;
            padding-top: 15px;
            text-align: center;
            font-size: 10px;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .watermark {
            position: absolute;
            opacity: 0.1;
            font-size: 100px;
            transform: rotate(-45deg);
            top: 300px;
            left: 100px;
        }
    </style>
</head>
<body>
    <!-- Watermark -->
    <div class="watermark">PAID</div>
    
    <!-- Header -->
    <div class="header">
        <div class="company-name">Diwali Firecracker Chit Fund</div>
        <div>123, Main Street, Chennai - 600001</div>
        <div>Phone: 044-12345678 | Email: info@diwalichitfund.com</div>
        <div class="receipt-title">PAYMENT RECEIPT</div>
    </div>
    
    <!-- Receipt Details -->
    <table class="details-table">
        <tr>
            <th>Receipt Number</th>
            <td>{{ $payment->receipt_number }}</td>
            <th>Payment Date</th>
            <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Member Name</th>
            <td>{{ $payment->user->name }}</td>
            <th>Mobile Number</th>
            <td>{{ $payment->user->mobile }}</td>
        </tr>
        <tr>
            <th>Enrollment Number</th>
            <td>{{ $payment->enrollment->enrollment_number }}</td>
            <th>Installment Number</th>
            <td>{{ $payment->installment_number }}</td>
        </tr>
        <tr>
            <th>Scheme Name</th>
            <td>{{ $payment->enrollment->scheme->name }}</td>
            <th>Monthly Amount</th>
            <td>₹{{ number_format($payment->enrollment->scheme->monthly_amount, 2) }}</td>
        </tr>
        <tr>
            <th>Payment Mode</th>
            <td>{{ ucwords(str_replace('_', ' ', $payment->payment_mode)) }}</td>
            <th>Reference Number</th>
            <td>{{ $payment->reference_number ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: right; font-size: 14px;">Amount Paid</th>
            <td style="font-size: 16px; font-weight: bold; color: #28a745;">
                ₹{{ number_format($payment->amount, 2) }}
            </td>
        </tr>
    </table>
    
    <!-- Amount in Words -->
    <div class="amount-in-words">
        <strong>Amount in Words:</strong> 
        {{ $this->numberToWords($payment->amount) }} Only
    </div>
    
    <!-- Payment Summary -->
    <h4>Payment Summary</h4>
    <table class="details-table">
        <tr>
            <th>Total Installments</th>
            <td>{{ $payment->enrollment->total_installments }}</td>
            <th>Paid Installments</th>
            <td>{{ $payment->enrollment->paid_installments }}</td>
        </tr>
        <tr>
            <th>Total Amount</th>
            <td>₹{{ number_format($payment->enrollment->total_amount, 2) }}</td>
            <th>Amount Paid</th>
            <td>₹{{ number_format($payment->enrollment->amount_paid, 2) }}</td>
        </tr>
        <tr>
            <th>Maturity Amount</th>
            <td colspan="3" style="font-weight: bold; color: #ff6b35;">
                ₹{{ number_format($payment->enrollment->maturity_amount, 2) }}
            </td>
        </tr>
    </table>
    
    <!-- Remarks -->
    @if($payment->remarks)
    <div style="margin-top: 20px;">
        <strong>Remarks:</strong> {{ $payment->remarks }}
    </div>
    @endif
    
    <!-- Signature -->
    <div class="signature">
        <div style="margin-bottom: 40px;">
            ___________________________<br>
            Authorized Signature
        </div>
        <div>
            Stamp
        </div>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <strong>Terms & Conditions:</strong><br>
        1. This receipt is computer generated and doesn't require signature.<br>
        2. Please keep this receipt for future reference.<br>
        3. All disputes are subject to Chennai jurisdiction only.<br>
        <br>
        <strong>Thank you for your payment!</strong><br>
        For any queries, contact: 044-12345678 or email: support@diwalichitfund.com
    </div>
</body>
</html>