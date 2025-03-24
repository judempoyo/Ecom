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

            <livewire:search.product-search  />

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

          @livewire('cart')


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
