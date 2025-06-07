
<div>
    <!-- Bouton du panier -->
    <flux:modal.trigger name="cart-modal">
        <flux:button  icon="shopping-cart" class="mx-4 relative" circle variant="ghost">
            @if(count($cart) > 0)
                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                    {{ array_sum(array_column($cart, 'quantity')) }}
                </span>
            @endif
        </flux:button>
    </flux:modal.trigger>

    <!-- Modal du panier -->
    <flux:modal name="cart-modal" variant="flyout" size="md">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Votre Panier</flux:heading>
                <flux:text class="mt-2">Gérez les articles de votre panier.</flux:text>
            </div>

            @if(count($cart) > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($cart as $id => $item)
                        <div class="py-4 flex items-center">
                            <div class="flex-shrink-0 h-16 w-16 rounded-md overflow-hidden">
                                <img src="{{ asset('storage/'.$item['image']) }}"
                                     alt="{{ $item['name'] }}"
                                     class="h-full w-full object-cover">
                            </div>

                            <div class="ml-4 flex-1">
                                <div class="flex justify-between">
                                    <h3 class="text-sm font-medium ">{{ $item['name'] }}</h3>
                                    <p class="ml-4 text-sm font-medium ">
                                        {{ number_format($item['price'] * $item['quantity'], 2) }} €
                                    </p>
                                </div>

                                <div class="mt-2 flex items-center justify-between">
                                    <div class="flex items-center border rounded">
                                        <button wire:click="updateQuantity('{{ $id }}', {{ $item['quantity'] - 1 }})"
                                                class="px-2 py-1 hover:bg-gray-100">-</button>
                                        <span class="px-3 text-sm">{{ $item['quantity'] }}</span>
                                        <button wire:click="updateQuantity('{{ $id }}', {{ $item['quantity'] + 1 }})"
                                                class="px-2 py-1 hover:bg-gray-100">+</button>
                                    </div>

                                    <button wire:click="removeFromCart('{{ $id }}')"
                                            class="ml-4 text-red-500 hover:text-red-700">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between text-base font-medium ">
                        <p>Total</p>
                        <p>{{ number_format(array_sum(array_map(function($item) { return $item['price'] * $item['quantity']; }, $cart)), 2) }} €</p>
                    </div>

                    <div class="mt-6">
                        @if(auth()->check())
                        <a href="{{ route('checkout') }}"
                        class="flex justify-center items-center px-8 py-6 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-teal-600 hover:bg-teal-700">
                         Passer la commande
                     </a>
        @else
            <div class="bg-teal-50 dark:bg-zinc-900 p-3 rounded mb-4">
                <p>Connectez-vous pour passer commande</p>
                <a href="{{ route('login') }}" class="font-medium underline text-teal-600 hover:italic hover:text-teal-750">Se connecter</a>
            </div>
        @endif
                        {{--
                        <a href="{{ route('products.index') }}"
                           class="flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-teal-600 hover:bg-teal-700">
                           Passer la commande
                        </a>
                        --}}
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium ">Panier vide</h3>
                    <p class="mt-1 text-sm text-gray-500">Commencez par ajouter des produits à votre panier.</p>
                </div>
            @endif
        </div>
    </flux:modal>
</div>
