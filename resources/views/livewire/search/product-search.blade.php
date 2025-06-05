<div class="flex-1 mx-4" x-data="{ isSearchOpen: false }">
    <!-- Formulaire de recherche desktop -->
    <form wire:submit.prevent="search" class="hidden sm:block">
        <div class="relative max-w-2xl mx-auto"> <!-- Conteneur limité en largeur -->
            <flux:input 
                name="query" 
                wire:model.live.debounce.300ms="query"
                icon:trailing="magnifying-glass" 
                placeholder="Rechercher des produits..." 
                class="w-full"
            />
            
            <!-- Résultats desktop - version élargie -->
            @if($query)
                <div class="absolute left-0 right-0 mt-1 bg-white dark:bg-zinc-800 rounded-lg shadow-xl z-50 border border-gray-200 dark:border-zinc-700 max-h-[100vh] overflow-y-auto w-full min-w-[48rem]">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                        @forelse($products as $product)
                            <a href="{{ route('products.show', $product) }}" 
                               class="flex items-start gap-4 p-3 hover:bg-gray-50 dark:hover:bg-zinc-700/50 rounded-lg transition-colors border border-gray-100 dark:border-zinc-700">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" 
                                         alt="{{ $product->name }}"
                                         class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 dark:bg-zinc-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-gray-900 dark:text-white line-clamp-2">{{ $product->name }}</h3>
                                    @if($product->price)
                                        <div class="mt-1 text-lg font-semibold text-primary-600 dark:text-primary-400">
                                            {{ number_format($product->price, 2) }} €
                                        </div>
                                    @endif
                                    @if($product->description)
                                        <p class="mt-1 text-sm text-gray-500 dark:text-zinc-400 line-clamp-2">
                                            {{ $product->description }}
                                        </p>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full p-4 text-center text-gray-500 dark:text-zinc-400">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="mt-2">Aucun résultat trouvé pour "{{ $query }}"</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </form>

    <!-- Bouton de recherche mobile -->
    <flux:button 
        icon="magnifying-glass" 
        @click="isSearchOpen = !isSearchOpen"
        class="sm:hidden focus:outline-none" 
        variant="ghost"
    ></flux:button>

    <!-- Champ de recherche mobile + résultats -->
    <div
        x-show="isSearchOpen"
        @click.away="isSearchOpen = false"
        x-transition
        class="fixed inset-x-0 top-16 bg-white dark:bg-zinc-900 shadow-lg sm:hidden z-50"
    >
        <form wire:submit.prevent="search" class="p-4">
            <div class="relative">
                <flux:input 
                    name="query"
                    wire:model.live.debounce.300ms="query"
                    x-ref="mobileSearchInput"
                    @click.stop
                    icon:trailing="magnifying-glass" 
                    placeholder="Rechercher des produits..." 
                />
            </div>
        </form>
        
        <!-- Résultats mobile -->
        @if($query)
            <div class="max-h-[calc(100vh-8rem)] overflow-y-auto border-t border-gray-200 dark:border-zinc-700">
                @forelse($products as $product)
                    <a href="{{ route('products.show', $product) }}" 
                       class="flex items-center gap-3 p-4 hover:bg-gray-100 dark:hover:bg-zinc-700 border-b border-gray-100 dark:border-zinc-700 last:border-0">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" 
                                 alt="{{ $product->name }}"
                                 class="w-12 h-12 object-cover rounded">
                        @else
                            <div class="w-12 h-12 bg-gray-200 dark:bg-zinc-600 rounded flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <div class="font-medium text-gray-900 dark:text-white truncate">{{ $product->name }}</div>
                            @if($product->price)
                                <div class="text-sm text-gray-500 dark:text-zinc-400">{{ number_format($product->price, 2) }} €</div>
                            @endif
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @empty
                    <div class="p-4 text-center text-gray-500 dark:text-zinc-400">
                        Aucun résultat trouvé pour "{{ $query }}"
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</div>