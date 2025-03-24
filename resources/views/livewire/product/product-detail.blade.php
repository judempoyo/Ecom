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
                                src="{{ asset('storage/' . $image->path) }}"
                                alt="{{ $product->name }}"
                                onclick="changeMainImage('{{ asset('storage/' . $image->path) }}')"
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
                        {{ $product->price }} €
                    </p>

                    <div class="flex items-center gap-2 mt-2 sm:mt-0">
                        <div class="flex items-center gap-1">
                            <!-- Affichage des étoiles de notation -->
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
                            ({{ $product->averageRating() }})
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

                <!-- Boutons d'action -->
                <div class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8">
                    <a
                        href="#"
                        class="flex items-center justify-center py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                    >
                        <svg class="w-5 h-5 -ms-2 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z"/>
                        </svg>
                        Ajouter aux favoris
                    </a>

                    <a
                        href="#"
                        class="text-white mt-4 sm:mt-0 bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 -ms-2 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6"/>
                        </svg>
                        Ajouter au panier
                    </a>
                </div>

                <!-- Description du produit -->
                <hr class="my-6 md:my-8 border-gray-200 dark:border-gray-800" />
                <p class="mb-6 text-gray-500 dark:text-gray-400">
                    {{ $product->description }}
                </p>

                <!-- Avis des clients -->
                <h2 id="reviews" class="text-xl font-bold mt-4">Avis des clients</h2>
                @foreach($product->reviews as $review)
                    <div class="border p-4 mt-4 rounded-lg shadow-sm">
                        <p class="text-gray-600">{{ $review->comment }}</p>
                        <p class="text-sm text-gray-500 mt-2">Note: {{ $review->rating }}/5</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Script pour changer l'image principale -->
<script>
    function changeMainImage(newSrc) {
        document.querySelector('.w-full.rounded-lg.shadow-lg').src = newSrc;
    }
</script>
