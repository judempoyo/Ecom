<div class="container mx-auto px-4 py-8 max-w-md">
    <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow">
        @if(!$paymentSuccess)
            <h2 class="text-xl font-semibold mb-4">Paiement Mobile Money</h2>
            <p class="mb-6">Total à payer: <span class="font-bold">{{ number_format($order->total_amount, 2) }} $</span></p>

            <form wire:submit.prevent="processPayment">
                <div class="space-y-4">
                    <!-- Réseau Mobile Money -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Réseau *</label>
                        <select wire:model="network" class="w-full px-3 py-2 border rounded-lg">
                            @foreach($networks as $net)
                                <option value="{{ $net }}">{{ ucfirst($net) }} Money</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Numéro de téléphone -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Numéro de téléphone *</label>
                        <input type="tel" wire:model="phoneNumber"
                               placeholder="Ex: 0991234567"
                               class="w-full px-3 py-2 border rounded-lg">
                        @error('phoneNumber') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Bouton de soumission -->
                    <button type="submit"
                            class="w-full bg-teal-600 text-white py-3 px-4 rounded-lg hover:bg-teal-700 transition"
                            :disabled="$isProcessing">
                        @if($isProcessing)
                            <span>Envoi de la demande de paiement...</span>
                        @else
                            <span>Payer avec Mobile Money</span>
                        @endif
                    </button>
                </div>
            </form>
        @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <h2 class="mt-4 text-xl font-semibold">Paiement réussi!</h2>
                <p class="mt-2">Votre paiement de {{ number_format($order->total_amount, 2) }} $ a été traité.</p>
                <a href="{{ route('order.confirmation', ['order' => $order->id]) }}"
                   class="mt-6 inline-block bg-teal-600 text-white py-2 px-4 rounded-lg hover:bg-teal-700 transition">
                    Voir ma commande
                </a>
            </div>
        @endif
    </div>
</div>
