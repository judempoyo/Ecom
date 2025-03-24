<div class="hidden md:flex   md:w-64">
        <div class="shadow rounded-lg p-4 sticky top-4">
            <h3 class="text-lg font-semibold mb-4">Filtrer par catégorie</h3>

            <ul class="space-y-2">
                <li>
                    <flux:button wire:click="$set('category', '')"
                        class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 transition-colors {{ $category === '' ? 'bg-teal-50 text-teal-600' : '' }}">
                        Toutes les catégories
                    </flux:button>
                </li>
                @foreach ($categories as $cat)
                    <li>
                        <flux:button wire:click="$set('category', '{{ $cat->id }}')"
                            class="w-full text-left px-3 py-2 rounded transition-colors flex justify-between items-center {{ $category == $cat->id ? 'bg-teal-50 text-teal-600' : '' }}">
                            <span>{{ $cat->name }}</span>
                            <span class="text-xs bg-gray-200 px-2 py-1 rounded-full">
                                {{ $cat->products_count }}
                            </span>
                        </flux:button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>