<div>
    <x-container>
        <x-card>
            <x-slot name="header">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Mes Commandes
                </h2>
            </x-slot>

            @if (session()->has('message'))
                <x-alert type="success" :message="session('message')" class="mb-4"/>
            @endif

            <div class="space-y-6">
                @forelse ($orders as $order)
                    <div class="p-4 border rounded-lg shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-medium">Commande #{{ $order->id }}</h3>
                                <p class="text-sm text-gray-500">
                                    Date: {{ $order->created_at->format('d/m/Y H:i') }}
                                </p>
                                <p class="mt-1">
                                    Statut: 
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </p>
                                <p class="mt-1 font-medium">
                                    Total: {{ number_format($order->total_amount, 2) }} XOF
                                </p>
                            </div>

                            @if($order->status !== 'cancelled')
                                <button wire:click="cancelOrder({{ $order->id }})" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande?')"
                                        class="px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700">
                                    Annuler
                                </button>
                            @endif
                        </div>

                        <div class="mt-4">
                            <h4 class="text-sm font-medium">Articles:</h4>
                            <ul class="mt-2 space-y-2">
                                @foreach ($order->items as $item)
                                    <li class="flex items-center justify-between text-sm">
                                        <span>
                                            {{ $item->quantity }} x {{ $item->product->name }}
                                        </span>
                                        <span>
                                            {{ number_format($item->price * $item->quantity, 2) }} XOF
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        @if($order->payments->count() > 0)
                            <div class="mt-4">
                                <h4 class="text-sm font-medium">Paiements:</h4>
                                <ul class="mt-2 space-y-2">
                                    @foreach ($order->payments as $payment)
                                        <li class="text-sm">
                                            {{ ucfirst($payment->payment_method) }}: 
                                            {{ number_format($payment->amount, 2) }} XOF 
                                            ({{ ucfirst($payment->status) }})
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">Vous n'avez aucune commande pour le moment.</p>
                @endforelse
            </div>
        </x-card>
    </x-container>
</div>