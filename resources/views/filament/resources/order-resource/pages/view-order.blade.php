<x-filament::page>

    <div class="bg-gray-100 dark:bg-zinc-900 rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold">Facture #{{ $record->id }}</h1>
                <p class="text-gray-500">Date: {{ $record->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="text-right">
                <p class="font-semibold">Statut: 
                    <span @class([
                        'px-2 py-1 rounded',
                        'bg-yellow-100 text-yellow-800' => $record->status === 'pending',
                        'bg-green-100 text-green-800' => $record->status === 'completed',
                        'bg-red-100 text-red-800' => $record->status === 'cancelled',
                    ])>
                        {{ ucfirst($record->status) }}
                    </span>
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <h2 class="text-lg font-semibold mb-2">Client</h2>
                <p>{{ $record->user->name }}</p>
                <p>{{ $record->user->email }}</p>
                <!-- Ajoutez d'autres informations client si nécessaire -->
            </div>
            <div class="text-right">
                <h2 class="text-lg font-semibold mb-2">Paiement</h2>
                @if($record->payments->count() > 0)
                    @foreach($record->payments as $payment)
                        <p>Méthode: {{ $payment->payment_method }}</p>
                        <p>Montant: {{ number_format($payment->amount, 2, ',', ' ') }} XOF</p>
                        <p>Statut: {{ ucfirst($payment->status) }}</p>
                        @if($payment->transaction_id)
                            <p>Transaction: {{ $payment->transaction_id }}</p>
                        @endif
                    @endforeach
                @else
                    <p class="text-red-500">Aucun paiement enregistré</p>
                @endif
            </div>
        </div>

        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4">Articles</h2>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 dark:bg-zinc-800">
                        <th class="p-3 text-left">Produit</th>
                        <th class="p-3 text-right">Prix unitaire</th>
                        <th class="p-3 text-right">Quantité</th>
                        <th class="p-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($record->items as $item)
                        <tr class="border-b">
                            <td class="p-3">{{ $item->product->name }}</td>
                            <td class="p-3 text-right">{{ number_format($item->price, 2, ',', ' ') }} XOF</td>
                            <td class="p-3 text-right">{{ $item->quantity }}</td>
                            <td class="p-3 text-right">{{ number_format($item->price * $item->quantity, 2, ',', ' ') }} XOF</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="p-3 text-right font-semibold">Total</td>
                        <td class="p-3 text-right font-semibold">{{ number_format($record->total_amount, 2, ',', ' ') }} XOF</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="text-right">
            <p class="text-sm text-gray-500">Merci pour votre commande !</p>
        </div>
    </div>
</x-filament::page>