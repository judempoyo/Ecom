<div>
    <h1>Liste des Produits</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($products as $product)
            <div class="border p-4">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                <h2 class="text-xl font-bold">{{ $product->name }}</h2>
                <p class="text-gray-600">{{ $product->description }}</p>
                <p class="text-lg font-semibold">{{ $product->price }} €</p>
                <a href="{{ route('product.show', $product->id) }}" class="text-blue-500">Voir les détails</a>
            </div>
        @endforeach
    </div>
    <!-- Pagination -->
    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>