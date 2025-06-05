<!-- resources/views/livewire/payment-tracker.blade.php -->
<table class="min-w-full">
    <thead>
        <tr>
            <th>ID Transaction</th>
            <th>Montant</th>
            <th>Méthode</th>
            <th>Statut</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
        <tr>
            <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
            <td>{{ number_format($payment->amount, 2) }} $</td>
            <td>{{ $payment->payment_method }}</td>
            <td>
                <span class="px-2 py-1 rounded-full text-xs 
                    {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                       ($payment->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                    {{ $payment->status }}
                </span>
            </td>
            <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $payments->links() }}