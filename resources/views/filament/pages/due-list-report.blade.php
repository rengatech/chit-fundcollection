<x-filament-panels::page>
    <form wire:submit.prevent="generateReport">
        {{ $this->form }}
        <div class="mt-4">
            <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded shadow">Search</button>
        </div>
    </form>

    @if(count($dues) > 0)
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4">Pending Payments</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border">Member</th>
                            <th class="p-2 border">Mobile</th>
                            <th class="p-2 border">Enrollment #</th>
                            <th class="p-2 border">Scheme</th>
                            <th class="p-2 border text-right">Monthly Msg</th>
                            <th class="p-2 border text-right">Last Installment Paid</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dues as $due)
                            <tr>
                                <td class="p-2 border">{{ $due->user->name }}</td>
                                <td class="p-2 border">{{ $due->user->mobile }}</td>
                                <td class="p-2 border">{{ $due->enrollment_number }}</td>
                                <td class="p-2 border">{{ $due->scheme->name }}</td>
                                <td class="p-2 border text-right">₹{{ number_format($due->scheme->monthly_amount, 2) }}</td>
                                <td class="p-2 border text-right">{{ $due->paid_installments }} / {{ $due->total_installments }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 no-print">
                <button onclick="window.print()" class="px-4 py-2 bg-primary-600 text-white rounded shadow">Print List</button>
            </div>
        </div>
    @else
        <div class="mt-8 text-center text-gray-500">
            No pending payments for this month.
        </div>
    @endif

    <style>
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</x-filament-panels::page>
