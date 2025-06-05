<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture #{{ $order->id }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }
        
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                padding: 0;
                margin: 0;
                font-size: 12pt;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .print-container {
                max-width: 100% !important;
                padding: 0 !important;
            }
        }
    </style>
</head>

<body class="bg-white text-gray-800 font-sans">
    <div class="container lg:max-w-2xl mx-auto p-6 print-container">
        <!-- Bouton d'impression -->
        <div class="no-print text-center mb-6">
            <button onclick="window.print()" class="bg-teal-600 text-white px-6 py-3 rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-colors duration-200 inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                </svg>
                Imprimer la facture
            </button>
        </div>

        <!-- En-tête -->
        <div class="flex justify-between items-start border-b-2 border-gray-200 pb-6 mb-6">
            <div class="w-2/5">
                <h1 class="text-xl font-bold text-gray-800">{{ config('app.name') }}</h1>
                <p class="text-gray-600">Adresse: 123 Rue des Entreprises</p>
                <p class="text-gray-600">Téléphone: +123 456 789</p>
                <p class="text-gray-600">Email: contact@entreprise.com</p>
            </div>

            <div class="w-2/5 text-right">
                <h2 class="text-2xl font-bold text-blue-500">FACTURE</h2>
                <div class="mt-2 space-y-1">
                    <p class="text-lg font-semibold">N°: {{ $order->id }}</p>
                    <p class="text-gray-600">Date: {{ $order->created_at->format('d/m/Y') }}</p>
                    <p class="text-gray-600">
                        Statut: 
                        <span @class([
                            'inline-block px-2 py-1 rounded text-xs font-medium',
                            'bg-yellow-100 text-yellow-800' => $order->status === 'pending',
                            'bg-green-100 text-green-800' => $order->status === 'completed',
                            'bg-red-100 text-red-800' => $order->status === 'cancelled',
                        ])>
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Client -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Client:</h3>
            <p class="font-bold">{{ $order->user->name }}</p>
            <p class="text-gray-600">{{ $order->user->email }}</p>
        </div>

        <!-- Articles -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4">Articles</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unitaire</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap">{{ $item->product->name }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-right">{{ number_format($item->price, 2, ',', ' ') }} XOF</td>
                                <td class="px-4 py-2 whitespace-nowrap text-right">{{ $item->quantity }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-right">{{ number_format($item->price * $item->quantity, 2, ',', ' ') }} XOF</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50 font-bold">
                            <td colspan="3" class="px-4 py-2 text-right">Total</td>
                            <td class="px-4 py-2 text-right">{{ number_format($order->total_amount, 2, ',', ' ') }} XOF</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Paiements -->
        @if ($order->payments->count() > 0)
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4">Paiements</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Méthode</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($order->payments as $payment)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $payment->payment_method }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ number_format($payment->amount, 2, ',', ' ') }} XOF</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ ucfirst($payment->status) }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $payment->transaction_id ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Message de remerciement -->
        <div class="mt-8 pt-4 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>Merci pour votre confiance !</p>
            <p class="mt-1">{{ config('app.name') }} - {{ date('Y') }}</p>
        </div>
    </div>

    <script>
        // Option d'impression automatique (décommenter si nécessaire)
        // window.onload = function() {
        //     setTimeout(function() {
        //         window.print();
        //     }, 1000);
        // };
    </script>
</body>
</html>