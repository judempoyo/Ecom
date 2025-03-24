<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Liste des Produits</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
            <a href="{{ route('products.show', $product->id) }}">
                <img class="w-full h-48 object-cover rounded-t-lg" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" />
            </a>
            <div class="p-5">
                <a href="{{ route('products.show', $product->id) }}">
                    <h5 class="text-lg font-semibold tracking-tight text-gray-900 dark:text-white line-clamp-2">{{ $product->name }}</h5>
                </a>
                
                <!-- Section des avis -->
                <div class="flex items-center mt-3 mb-4">
                    @php
                        $averageRating = $product->reviews->avg('rating') ?? 0;
                        $fullStars = floor($averageRating);
                        $hasHalfStar = $averageRating - $fullStars >= 0.5;
                        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                    @endphp
                    
                    <div class="flex items-center">
                        @for($i = 0; $i < $fullStars; $i++)
                            <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                            </svg>
                        @endfor
                        
                        @if($hasHalfStar)
                            <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                <defs>
                                    <linearGradient id="half-star" x1="0" x2="100%" y1="0" y2="0">
                                        <stop offset="50%" stop-color="currentColor"/>
                                        <stop offset="50%" stop-color="#D1D5DB"/>
                                    </linearGradient>
                                </defs>
                                <path fill="url(#half-star)" d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                            </svg>
                        @endif
                        
                        @for($i = 0; $i < $emptyStars; $i++)
                            <svg class="w-4 h-4 text-gray-300 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                            </svg>
                        @endfor
                        
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded ml-2 dark:bg-blue-200 dark:text-blue-800">
                            {{ number_format($averageRating, 1) }}
                        </span>
                    </div>
                    
                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">
                        ({{ $product->reviews->count() }} avis)
                    </span>
                </div>
                
                <!-- Prix et bouton -->
                <div class="flex items-center justify-between mt-4">
                    <span class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($product->price, 2) }} €</span>
                    
                    @if($product->stock > 0)
                        <a href="{{ route('products.show', $product->id) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-200">
                            Voir le produit
                        </a>
                    @else
                        <span class="text-sm text-red-600 dark:text-red-400">Rupture de stock</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
   {{--   <div class="mt-8">
        {{ $products->links() }}
    </div>  --}}
</div>  