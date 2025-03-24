<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <!-- Header -->
        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            @auth
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
            @endauth
            <!-- Logo et lien vers la page d'accueil -->
            <a href="{{ route('home') }}" class="ml-2 mr-5 flex items-center space-x-2 lg:ml-0" wire:navigate>
                <x-app-logo />
            </a>

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

            <!-- Navigation principale -->
            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Accueil') }}
                </flux:navbar.item>
                <flux:navbar.item icon="tag" :href="route('products.index')" :current="request()->routeIs('promotions')" wire:navigate>
                    {{ __('Promotions') }}
                </flux:navbar.item>
                <flux:navbar.item icon="shopping-bag" :href="route('products.index')" :current="request()->routeIs('products.index')" wire:navigate>
                    {{ __('Produits') }}
                </flux:navbar.item>
            </flux:navbar>

            <flux:spacer />

            <!-- Bouton de bascule du mode sombre -->
            <flux:tooltip :content="__('Toggle dark mode')" position="bottom">
                <flux:button circle x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle" aria-label="Toggle dark mode" />
            </flux:tooltip>

            <!-- Panier d'achat -->
            <flux:button as="a" icon="shopping-cart"  href="{{ route('products.index') }}" class="mx-4 relative" wire:navigate circle variant="ghost">
                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">3</span></flux:button>


            <!-- Menu utilisateur -->
            @if(auth()->check())
                <flux:dropdown position="top" align="end">
                    <flux:profile circle class="rounded-full cursor-pointer" avatar="{{ asset('storage/' . auth()->user()->profile_photo) }}"  />
                    <flux:menu>
                        <flux:menu.radio.group>
                            <div class="p-0 text-sm font-normal">
                                <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                        <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                        >
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>

                                    <div class="grid flex-1 text-left text-sm leading-tight">
                                        <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Paramètres') }}</flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                                {{ __('Déconnexion') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            @else
                <!-- Liens de connexion et d'inscription -->
                <flux:navbar class="-mb-px max-lg:hidden">
                    <flux:navbar.item icon="log-in" :href="route('login')" :current="request()->routeIs('login')" wire:navigate>
                        {{ __('Connexion') }}
                    </flux:navbar.item>
                    <flux:navbar.item icon="log-out" :href="route('register')" :current="request()->routeIs('register')" wire:navigate>
                        {{ __('Inscription') }}
                    </flux:navbar.item>
                </flux:navbar>
            @endif
        </flux:header>

        <!-- Mobile Menu (uniquement si l'utilisateur est authentifié) -->
        @if(auth()->check())
        <flux:sidebar stashable sticky class="lg:hidden border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="ml-1 flex items-center space-x-2" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')">
                    <flux:navlist.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="shopping-bag" :href="route('products.index')" :current="request()->routeIs('products.index')" wire:navigate>
                        {{ __('Produits') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

        </flux:sidebar>

        @endif

        {{ $slot }}

        @fluxScripts
    </body>
</html>
