<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Finaliser votre commande</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Formulaire -->
        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Adresse de livraison</h2>

            <form wire:submit.prevent="placeOrder">
                <div class="space-y-4 mb-6">
                    <!-- Rue -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Adresse *</label>
                        <input type="text" wire:model="address.street"
                               class="w-full px-3 py-2 border border-gray-600 rounded-lg">
                        @error('address.street') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Ville et Province -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Ville *</label>
                            <input type="text" wire:model="address.city"
                                   class="w-full px-3 py-2 border border-gray-600 rounded-lg">
                            @error('address.city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Province *</label>
                            <select wire:model="address.state"
                                    class="w-full px-3 py-2 border border-gray-600 rounded-lg">
                                <option value="">Sélectionnez</option>
                                @foreach($states as $state)
                                <option value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                            </select>
                            @error('address.state') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Livraison -->
                <div class="mb-6 p-4 border border-gray-600 rounded-lg">
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" wire:model="includeShipping"
                               class="h-4 w-4 text-teal-600 focus:ring-teal-500">
                        <span>Inclure les frais de livraison (5$)</span>
                    </label>
                </div>

                <!-- Paiement -->
                <h2 class="text-xl font-semibold mb-4">Méthode de paiement</h2>
                <div class="space-y-3 mb-6">
                    <label class="flex items-center space-x-3">
                        <input type="radio" wire:model="paymentMethod" value="mobile_money"
                               class="h-4 w-4 text-teal-600 focus:ring-teal-500">
                        <span>Mobile Money</span>
                    </label>
                    <label class="flex items-center space-x-3">
                        <input type="radio" wire:model="paymentMethod" value="cash"
                               class="h-4 w-4 text-teal-600 focus:ring-teal-500">
                        <span>Paiement en espèces</span>
                    </label>
                    <label class="flex items-center space-x-3">
                        <input type="radio" wire:model="paymentMethod" value="card"
                               class="h-4 w-4 text-teal-600 focus:ring-teal-500">
                        <span>Carte bancaire</span>
                    </label>
                    @error('paymentMethod') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <button type="submit"
                        class="w-full bg-teal-600 text-white py-3 px-4 rounded-lg hover:bg-teal-700 transition">
                    Confirmer la commande ({{ number_format($total, 2) }} $)
                </button>
            </form>
        </div>

        <!-- Récapitulatif -->
        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Votre commande</h2>

            <div class="divide-y">
                @foreach($cartItems as $item)
                    <div class="py-4 flex justify-between">
                        <div class="flex items-center">
                            <img src="{{ asset('storage/'.$item['image']) }}"
                                 class="w-16 h-16 object-cover rounded">
                            <div class="ml-4">
                                <h3 class="font-medium">{{ $item['name'] }}</h3>
                                <p class="text-sm ">
                                    {{ $item['quantity'] }} × {{ number_format($item['price'], 2) }} $
                                </p>
                            </div>
                        </div>
                        <span class="font-medium">
                            {{ number_format($item['price'] * $item['quantity'], 2) }} $
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="border-t pt-4 space-y-3">
                <div class="flex justify-between">
                    <span>Sous-total</span>
                    <span>{{ number_format($subtotal, 2) }} $</span>
                </div>
                @if($shipping > 0)
                    <div class="flex justify-between">
                        <span>Livraison</span>
                        <span>{{ number_format($shipping, 2) }} $</span>
                    </div>
                @endif
                <div class="flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span>{{ number_format($total, 2) }} $</span>
                </div>
            </div>
        </div>
    </div>
</div>
