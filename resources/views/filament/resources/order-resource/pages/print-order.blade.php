<!DOCTYPE html>
<html>
<head>
    <title>Facture #{{ $record->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .section { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row { font-weight: bold; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="header">
            <div>
                <h1>Facture #{{ $record->id }}</h1>
                <p>Date: {{ $record->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p><strong>Statut:</strong> {{ ucfirst($record->status) }}</p>
            </div>
        </div>

        <div class="section" style="display: flex; justify-content: space-between;">
            <div>
                <h2>Client</h2>
                <p>{{ $record->user->name }}</p>
                <p>{{ $record->user->email }}</p>
            </div>
            <div>
                <h2>Paiement</h2>
                @if($record->payments->count() > 0)
                    @foreach($record->payments as $payment)
                        <p>Méthode: {{ $payment->payment_method }}</p>
                        <p>Montant: {{ number_format($payment->amount, 2, ',', ' ') }} XOF</p>
                        <p>Statut: {{ ucfirst($payment->status) }}</p>
                    @endforeach
                @else
                    <p>Aucun paiement enregistré</p>
                @endif
            </div>
        </div>

        <div class="section">
            <h2>Articles</h2>
            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th class="text-right">Prix unitaire</th>
                        <th class="text-right">Quantité</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($record->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td class="text-right">{{ number_format($item->price, 2, ',', ' ') }} XOF</td>
                            <td class="text-right">{{ $item->quantity }}</td>
                            <td class="text-right">{{ number_format($item->price * $item->quantity, 2, ',', ' ') }} XOF</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="3" class="text-right">Total</td>
                        <td class="text-right">{{ number_format($record->total_amount, 2, ',', ' ') }} XOF</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="text-center no-print" style="margin-top: 30px;">
            <button onclick="window.print()" style="padding: 8px 16px; background: #4f46e5; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Imprimer la facture
            </button>
        </div>
    </div>
</body>
</html>