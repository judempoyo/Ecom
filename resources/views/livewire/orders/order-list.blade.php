<div class="min-h-screen bg-gray-50 dark:bg-zinc-800 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8 border-b border-gray-200 dark:border-gray-700 pb-6">
            <h2 class="text-2xl font-bold ">Historique de Commandes</h2>
            <p class="mt-1 text-sm ">Consultez l'état de vos commandes passées</p>
        </div>

        <!-- Message flash -->
        @if (session()->has('message'))
            <div class="mb-6 p-4 rounded-md bg-green-50 border border-green-200">
                <div class="flex items-center text-green-800">
                    <svg class="h-5 w-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">{{ session('message') }}</span>
                </div>
            </div>
        @endif

        <!-- Liste des commandes -->
        <div class="space-y-6">
            @forelse ($orders as $order)
                <div class="bg-gray-100 dark:bg-zinc-900 overflow-hidden shadow-lg rounded-lg border border-gray-200 dark:border-gray-800  hover:shadow-xl transition-shadow duration-200">
                    <!-- En-tête de la commande -->
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800  flex justify-between items-start flex-wrap gap-4">
                        <div>
                            <h3 class="text-lg font-semibold  flex items-center gap-2">
                                <svg class="w-5 h-5 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Commande #{{ $order->id }}
                            </h3>
                            <p class="mt-1 text-sm ">
                                Passée le {{ $order->created_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                            
                            <span class="text-lg font-semibold">
                                {{ number_format($order->total_amount, 2) }} XOF
                            </span>
                            
                            @if($order->status === 'pending')
                                <button wire:click="cancelOrder({{ $order->id }})" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande?')"
                                        class="px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700 transition-colors flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Annuler
                                </button>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Détails des articles -->
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h4 class="text-sm font-medium  mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Articles commandés
                        </h4>
                        <ul class="divide-y divide-gray-200 dark:divide-gray-500">
                            @foreach ($order->items as $item)
                                <li class="py-3 flex justify-between items-center">
                                    <div class="flex items-center gap-3">
                                        <span class=" text-sm">
                                            {{ $item->quantity }} ×
                                        </span>
                                        <span class="font-medium ">
                                            {{ $item->product->name }}
                                        </span>
                                    </div>
                                    <span class="">
                                        {{ number_format($item->price * $item->quantity, 2) }} XOF
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- Paiements -->
                    @if($order->payments->count() > 0)
                        <div class="px-6 py-4">
                            <h4 class="text-sm font-medium  mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Transactions
                            </h4>
                            <ul class="space-y-3">
                                @foreach ($order->payments as $payment)
                                    <li class="flex justify-between items-center text-sm">
                                        <div class="flex items-center gap-2">
                                            @if($payment->payment_method === 'mobile_money')
                                                <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                            <span class="capitalize">{{ $payment->payment_method }}</span>
                                            <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">
                                                {{ $payment->transaction_id }}
                                            </span>
                                        </div>
                                        <div class="text-right">
                                            <span class="font-medium">{{ number_format($payment->amount, 2) }} XOF</span>
                                            <span class="block text-xs  capitalize">{{ $payment->status }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium ">Aucune commande trouvée</h3>
                    <p class="mt-1 text-sm ">Vous n'avez passé aucune commande pour le moment.</p>
                    <div class="mt-6">
                        <a href="{{ route('home') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                            Retour à l'accueil
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>