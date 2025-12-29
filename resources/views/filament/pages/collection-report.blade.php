<x-filament-panels::page>
    <form wire:submit.prevent="generateReport">
        {{ $this->form }}
    </form>

    @if(count($payments) > 0)
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4">Collection Summary</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border">Receipt #</th>
                            <th class="p-2 border">Date</th>
                            <th class="p-2 border">Member</th>
                            <th class="p-2 border">Enrollment #</th>
                            <th class="p-2 border text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td class="p-2 border">{{ $payment->receipt_number }}</td>
                                <td class="p-2 border">{{ $payment->payment_date }}</td>
                                <td class="p-2 border">{{ $payment->user->name }}</td>
                                <td class="p-2 border">{{ $payment->enrollment->enrollment_number }}</td>
                                <td class="p-2 border text-right">₹{{ number_format($payment->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-bold bg-gray-50">
                            <td colspan="4" class="p-2 border text-right">Total</td>
                            <td class="p-2 border text-right">₹{{ number_format($total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="mt-4 no-print">
                <button onclick="window.print()" class="px-4 py-2 bg-primary-600 text-white rounded shadow">Print Report</button>
            </div>
        </div>
    @else
        <div class="mt-8 text-center text-gray-500">
            No payments found for the selected range.
        </div>
    @endif

    <style>
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</x-filament-panels::page>
