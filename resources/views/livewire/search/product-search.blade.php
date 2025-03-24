<!-- Barre de recherche -->
<div class="flex-1 mx-4" x-data="{ isSearchOpen: false }">
<!-- Formulaire de recherche (visible sur les grands écrans) -->
<form action="{{ route('products.index') }}" method="GET" class="hidden sm:block">
<div class="relative">
 <flux:input name="query" icon:trailing="magnifying-glass" placeholder="Rechercher des produits..." />
 {{--  <input
     type="text"
     name="query"
     placeholder="Rechercher des produits..."
     class="w-full px-4 py-2 rounded-lg border border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
 />
 <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 focus:outline-none">
     <flux:icon name="magnifying-glass" class="h-5 w-5 text-zinc-500 dark:text-zinc-400" />
 </button>  --}}
</div>
</form>

<!-- Bouton de recherche (visible uniquement sur les petits écrans) -->
{{--  <button
@click="isSearchOpen = !isSearchOpen"
class="sm:hidden focus:outline-none"
>
<flux:icon name="magnifying-glass" class="h-5 w-5 text-zinc-500 dark:text-zinc-400" />
</button>  --}}

<flux:button icon="magnifying-glass" @click="isSearchOpen = !isSearchOpen"
class="sm:hidden focus:outline-none" variant="ghost"></flux:button>
<!-- Champ de recherche mobile (apparaît en dessous du header) -->
<div
x-show="isSearchOpen"
@click.away="isSearchOpen = false"
class="fixed inset-x-0 top-16 bg-white dark:bg-zinc-900 shadow-lg sm:hidden z-50"
>
<form action="{{ route('products.index') }}" method="GET" class="p-4">
 <div class="relative">
     <flux:input  name="query" x-ref="mobileSearchInput"
         @click.stop icon:trailing="magnifying-glass" placeholder="Rechercher des produits..." />
     {{--  <input
         type="text"
         name="query"
         placeholder="Rechercher des produits..."
         class="w-full px-4 py-2 rounded-lg border border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
         x-ref="mobileSearchInput"
         @click.stop
     />
     <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 focus:outline-none">
         <flux:icon name="magnifying-glass" class="h-5 w-5 text-zinc-500 dark:text-zinc-400" />
     </button>  --}}
 </div>
</form>
</div>
</div>