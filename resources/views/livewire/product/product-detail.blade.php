<section class="py-8 bg-white md:py-16 dark:bg-gray-900 antialiased">
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
        <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16">
            <!-- Section des images du produit -->
            <div class="shrink-0 max-w-md lg:max-w-lg mx-auto">
                <!-- Image principale -->
                <img
                    class="w-full rounded-lg shadow-lg dark:hidden"
                    src="{{ asset('storage/' . $product->image) }}"
                    alt="{{ $product->name }}"
                />
                <img
                    class="w-full rounded-lg shadow-lg hidden dark:block"
                    src="{{ asset('storage/' . $product->image) }}"
                    alt="{{ $product->name }}"
                />

                <!-- Galerie d'images supplémentaires -->
                @if($product->images->count() > 0)
                    <div class="grid grid-cols-3 gap-4 mt-4">
                        @foreach($product->images as $image)
                            <img
                                class="w-full h-24 object-cover rounded-lg shadow-sm cursor-pointer hover:opacity-80"
                                src="{{ asset('storage/' . $image->image_path) }}"
                                alt="{{ $product->name }}"
                                onclick="changeMainImage('{{ asset('storage/' . $image->image_path) }}')"
                            />
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Section des détails du produit -->
            <div class="mt-6 sm:mt-8 lg:mt-0">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                    {{ $product->name }}
                </h1>

                <!-- Prix et notation -->
                <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
                    <p class="text-2xl font-extrabold text-gray-900 sm:text-3xl dark:text-white">
                        {{ number_format($product->price, 2) }} €
                    </p>

                    <div class="flex items-center gap-2 mt-2 sm:mt-0">
                        <div class="flex items-center gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $product->averageRating())
                                    <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <p class="text-sm font-medium leading-none text-gray-500 dark:text-gray-400">
                            ({{ number_format($product->averageRating(), 1) }})
                        </p>
                        <a href="#reviews" class="text-sm font-medium leading-none text-gray-900 underline hover:no-underline dark:text-white">
                            {{ $product->reviews->count() }} avis
                        </a>
                    </div>
                </div>

                <!-- Stock disponible -->
                <p class="mt-4 text-gray-600 dark:text-gray-400">
                    @if($product->stock > 0)
                        <span class="text-green-500">En stock ({{ $product->stock }})</span>
                    @else
                        <span class="text-red-500">Rupture de stock</span>
                    @endif
                </p>

                <!-- Sélecteur de quantité -->
                <div class="mt-6 flex items-center gap-4">
                    <div class="flex items-center border rounded-lg">
                        <button wire:click="decrement" class="px-3 py-1 text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                            -
                        </button>
                        <span class="px-4">{{ $quantity }}</span>
                        <button wire:click="increment" class="px-3 py-1 text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                            +
                        </button>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8">
                    <button
                        class="flex items-center justify-center py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                    >
                        <svg class="w-5 h-5 -ms-2 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z"/>
                        </svg>
                        Favoris
                    </button>

                    <button
                        wire:click="addToCart"
                        class="text-white mt-4 sm:mt-0 bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 flex items-center justify-center"
                        @if($product->stock <= 0) disabled @endif
                    >
                        <svg class="w-5 h-5 -ms-2 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6"/>
                        </svg>
                        Ajouter au panier
                    </button>
                </div>

                <!-- Description du produit -->
                <hr class="my-6 md:my-8 border-gray-200 dark:border-gray-800" />
                <p class="mb-6 text-gray-500 dark:text-gray-400">
                    {{ $product->description }}
                </p>

                <!-- Section d'avis -->
                <div id="reviews" class="mt-12">
                    <h2 class="text-2xl font-bold mb-6">Avis des clients</h2>

                    <!-- Formulaire d'avis -->
                    @auth
                    @if($hasReviewed)
                    <div class="bg-green-50 text-green-700 p-4 rounded-md dark:bg-green-900 dark:text-green-100 mb-4">
                        Vous avez déjà donné votre avis sur ce produit.
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md mb-8">
                   
                            <h3 class="text-lg font-medium mb-4">Donnez votre avis</h3>
                            
                            <form wire:submit.prevent="submitReview">
                                <!-- Notation -->
                                <div class="flex items-center mb-4">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg wire:click="$set('rating', {{ $i }})" 
                                             class="w-6 h-6 cursor-pointer {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}" 
                                             fill="currentColor" viewBox="0 0 24 24">
                                             <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                        </svg>
                                    @endfor
                                </div>
                                
                                <!-- Commentaire -->
                                <textarea wire:model="comment" 
                                          class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                          rows="4" 
                                          placeholder="Votre avis..."></textarea>
                                @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                
                                <!-- Bouton de soumission -->
                                <button type="submit" 
                                        class="mt-4 px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors">
                                    Envoyer l'avis
                                </button>
                            </form>
                            
                            @if(session()->has('reviewSubmitted'))
                                <div class="mt-4 p-3 bg-green-100 text-green-700 rounded-md dark:bg-green-900 dark:text-green-100">
                                    {{ session('reviewSubmitted') }}
                                </div>
                            @endif
                        </div>
                         @endif
                    @else
                        <div class="bg-blue-50 text-blue-700 p-4 rounded-md dark:bg-blue-900 dark:text-blue-100 mb-8">
                            <p>Vous devez être connecté pour poster un avis. <a href="{{ route('login') }}" class="font-medium underline">Connectez-vous</a> ou <a href="{{ route('register') }}" class="font-medium underline">créez un compte</a></p>
                        </div>
                    @endauth

                    <!-- Liste des avis -->
                    <div class="space-y-6">
                        @forelse($product->reviews as $review)
                            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                            <span class="text-gray-600 dark:text-gray-300">{{ substr($review->user->name, 0, 1) }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="font-medium">{{ $review->user->name }}</h4>
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                                       <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                
                                <div class="mt-4">
                                    <p class="text-gray-700 dark:text-gray-300">{{ $review->comment }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">Aucun avis pour ce produit.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Script pour changer l'image principale -->
<script>
    function changeMainImage(newSrc) {
        const images = document.querySelectorAll('.w-full.rounded-lg.shadow-lg');
        images.forEach(img => img.src = newSrc);
    }
</script>