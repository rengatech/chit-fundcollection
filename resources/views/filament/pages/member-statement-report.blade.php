<x-filament-panels::page>
    <form wire:submit.prevent="generateReport">
        {{ $this->form }}
    </form>

    @if($user && count($payments) > 0)
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4">Statement for {{ $user->name }}</h2>
            <div class="mb-4">
                <p><strong>Mobile:</strong> {{ $user->mobile }}</p>
                <p><strong>Address:</strong> {{ $user->address }}, {{ $user->city }} - {{ $user->pincode }}</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border">Receipt #</th>
                            <th class="p-2 border">Date</th>
                            <th class="p-2 border">Enrollment #</th>
                            <th class="p-2 border">Installment</th>
                            <th class="p-2 border text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td class="p-2 border">{{ $payment->receipt_number }}</td>
                                <td class="p-2 border">{{ $payment->payment_date }}</td>
                                <td class="p-2 border">{{ $payment->enrollment->enrollment_number }}</td>
                                <td class="p-2 border">{{ $payment->installment_number }}</td>
                                <td class="p-2 border text-right">₹{{ number_format($payment->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-bold bg-gray-50">
                            <td colspan="4" class="p-2 border text-right">Total Paid</td>
                            <td class="p-2 border text-right">₹{{ number_format($payments->sum('amount'), 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="mt-4 no-print">
                <button onclick="window.print()" class="px-4 py-2 bg-primary-600 text-white rounded shadow">Print Statement</button>
            </div>
        </div>
    @elseif($user)
        <div class="mt-8 text-center text-gray-500">
            No payments found for this member.
        </div>
    @endif

    <style>
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</x-filament-panels::page>
