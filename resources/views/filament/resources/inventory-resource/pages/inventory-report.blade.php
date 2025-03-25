<x-filament-panels::page>


    <x-filament::form wire:submit.prevent="generateReport">
        {{ $this->form }}

        <x-filament::button type="submit" class="mt-4">
            Générer le rapport
        </x-filament::button>

        @if($this->generateReport())
            <x-filament::button 
                type="button" 
                wire:click="printReport" 
                color="success" 
                class="mt-4"
            >
                Imprimer le rapport
            </x-filament::button>

            <div class="mt-6">
                <h2 class="text-lg font-medium mb-4">Résultats du rapport</h2>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($this->generateReport() as $inventory)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $inventory->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $inventory->product->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $inventory->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $inventory->movement_type === 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $inventory->movement_type === 'in' ? 'Entrée' : 'Sortie' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $inventory->notes }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </x-filament::form>
</x-filament-panels::page>