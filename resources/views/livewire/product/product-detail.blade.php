<div>
    <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
    <p class="text-gray-600">{{ $product->description }}</p>
    <p class="text-lg font-semibold">{{ $product->price }} €</p>
    <p>Stock: {{ $product->stock }}</p>

    <h2 class="text-xl font-bold mt-4">Avis des clients</h2>
    @foreach($product->reviews as $review)
        <div class="border p-2 mt-2">
            <p>{{ $review->comment }}</p>
            <p>Note: {{ $review->rating }}/5</p>
        </div>
    @endforeach
</div>