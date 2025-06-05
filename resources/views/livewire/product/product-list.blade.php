<div class="flex flex-col md:flex-row gap-8">
    <!-- Sidebar avec CategoryNavigation -->
    <div class="hidden md:flex md:w-64">
        <div class="shadow rounded-lg p-4 sticky top-4">
            <h3 class="text-lg font-semibold mb-4">Filtrer par catégorie</h3>
    
            <ul class="space-y-2">
                <li>
                    <button wire:click="$set('category', '')"
                        class="w-full text-left px-3 py-2 rounded  transition-colors {{ $category === '' ? 'bg-teal-50 text-teal-600 dark:bg-teal-500 dark:text-black  hover:bg-teal-100 dark:hover:bg-teal-600 ' : 'text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-900' }}">
                        Toutes les catégories
                    </button>
                </li>
                @foreach ($categories as $cat)
                    <li>
                        <button wire:click="$set('category', '{{ $cat->id }}')"
                            class="w-full text-left px-3 py-2 rounded transition-colors flex justify-between  items-center {{ $category == $cat->id ? 'bg-teal-50 dark:bg-teal-500 dark:text-black  text-teal-600 hover:bg-teal-100 dark:hover:bg-teal-600' : 'text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-900 ' }}">
                            <span>{{ $cat->name }}</span>
                            <span class="text-xs bg-gray-200 dark:bg-zinc-700 text-teal-600 dark:text-white px-2 py-1 rounded-full">
                                {{ $cat->products_count }}
                            </span>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!-- Liste des produits -->
    <div class="flex-1">

        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Liste des Produits</h1>
        <div class="mb-6 flex flex-col md:flex-row gap-4">
            <!-- Input de recherche -->
            <div class="w-full md:w-1/4">
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="Rechercher des produits..."
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>
        
            <!-- Conteneur des selects -->
            <div class="w-full md:w-auto flex flex-col sm:flex-row gap-2 sm:gap-4">
                <!-- Select de catégorie (mobile seulement) -->
                <div class="md:hidden w-full">
                    <flux:select wire:model.live="category" placeholder="Catégorie">
                        <flux:select.option value="">Toutes les catégories</flux:select.option>
                        @foreach ($categories as $category)
                            <flux:select.option value="{{ $category->id }}">
                                <div class="flex items-center gap-2">
                                    <flux:icon.folder variant="mini" class="text-zinc-400" />
                                    {{ $category->name }}
                                </div>
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
        
                <!-- Select de tri -->
                <div class="w-full sm:w-auto">
                    <flux:select wire:model.live="sortBy" placeholder="Trier par">
                        <flux:select.option value="name">
                            <div class="flex items-center gap-2">
                                <flux:icon.arrow-down-a-z variant="mini" class="text-zinc-400" />
                                Nom
                            </div>
                        </flux:select.option>
                        <flux:select.option value="price">
                            <div class="flex items-center gap-2">
                                <flux:icon.dollar-sign variant="mini" class="text-zinc-400" />
                                Prix
                            </div>
                        </flux:select.option>
                        <flux:select.option value="created_at">
                            <div class="flex items-center gap-2">
                                <flux:icon.sparkles variant="mini" class="text-zinc-400" />
                                Nouveautés
                            </div>
                        </flux:select.option>
                    </flux:select>
                </div>
            </div>
        </div>

        @if ($products->isEmpty())
        <div class="text-center py-16 px-4 max-w-sm mx-auto">
            <!-- Icône illustrative -->
            <div class="mx-auto mb-6 text-gray-400 dark:text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            
            <!-- Message principal -->
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-3">
                Oups, rien ici...
            </h3>
            
            <!-- Message secondaire -->
            <p class="text-gray-500 dark:text-gray-400 mb-6">
                @if($search || $category)
                    Aucun produit ne correspond à vos filtres actuels.
                @else
                    Notre catalogue semble vide pour le moment.
                @endif
            </p>
            
            <!-- Bouton d'action -->
            <div class="flex justify-center gap-3">
                @if($search || $category)
                    <button wire:click="$set('search', '')" 
                            wire:click="$set('category', '')"
                            class="px-5 py-2.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Réinitialiser
                    </button>
                @endif
                <a href="{{ route('products.index') }}" 
                   class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Voir le catalogue
                </a>
            </div>
        </div>
        @else
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
        wire:loading.class="opacity-50">
       @foreach ($products as $product)
           <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-zinc-800 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                        <a href="{{ route('products.show', $product->id) }}">
                            <img class="w-full h-48 object-cover rounded-t-lg"
                                src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" />
                        </a>
                        <div class="p-5">
                            <a href="{{ route('products.show', $product->id) }}">
                                <h5
                                    class="text-lg font-semibold tracking-tight text-gray-900 dark:text-white line-clamp-2">
                                    {{ $product->name }}</h5>
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
                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <svg class="w-4 h-4 text-yellow-300" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                            <path
                                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                        </svg>
                                    @endfor

                                    @if ($hasHalfStar)
                                        <svg class="w-4 h-4 text-yellow-300" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                            <defs>
                                                <linearGradient id="half-star" x1="0" x2="100%"
                                                    y1="0" y2="0">
                                                    <stop offset="50%" stop-color="currentColor" />
                                                    <stop offset="50%" stop-color="#D1D5DB" />
                                                </linearGradient>
                                            </defs>
                                            <path fill="url(#half-star)"
                                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                        </svg>
                                    @endif

                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <svg class="w-4 h-4 text-gray-300 dark:text-gray-500" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                            <path
                                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                        </svg>
                                    @endfor

                                    <span
                                        class="bg-teal-100 text-teal-800 text-xs font-semibold px-2 py-0.5 rounded ml-2 dark:bg-teal-200 dark:text-teal-800">
                                        {{ number_format($averageRating, 1) }}
                                    </span>
                                </div>

                                <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">
                                    ({{ $product->reviews->count() }} avis)
                                </span>
                            </div>

                            <!-- Prix et bouton -->
                            <div class="flex items-center justify-between mt-4">
                                <span
                                    class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($product->price, 2) }}
                                    €</span>

                                @if ($product->stock > 0)
                                <button wire:click="$dispatch('addToCart', { productId: {{ $product->id }} })" 
                                    class="px-3 py-1 bg-teal-600 text-white rounded hover:bg-teal-700">
                                Ajouter au panier
                            </button>
                                @else
                                    <span class="text-sm text-red-600 dark:text-red-400">Rupture de stock</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div x-intersect="$wire.loadMore()" class="h-1"></div>
            
            <div wire:loading.flex class="justify-center my-8">
                <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-teal-600"></div>
            </div>
        @endif

        <!-- Pagination -->
       {{--   <div class="mt-8">
            {{ $products->links() }}
        </div>  --}}
    </div>
