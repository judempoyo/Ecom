<x-layouts.app :title="__('Confirmation de la commande')">

    <div class="container mx-auto px-4 py-12 text-center">
        <div class="max-w-md mx-auto bg-white dark:bg-zinc-800 p-8 rounded-lg shadow">
        <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        
        <h1 class="text-2xl font-bold mb-2">Commande confirmée !</h1>
        <p class="mb-6">Merci pour votre commande #{{ $order->id }}</p>
        
        <div class="bg-gray-50 dark:bg-zinc-700 p-4 rounded-lg mb-6">
            <p class="font-medium">Total payé: {{ number_format($order->total_amount, 2) }} €</p>
            <p class="text-sm text-gray-500">Un email de confirmation vous a été envoyé</p>
        </div>

        <a href="{{ route('home') }}" 
           class="inline-block px-6 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">
            Retour à l'accueil
        </a>
    </div>
</div>

    </x-layouts.app>