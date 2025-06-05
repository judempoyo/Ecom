<div class="w-full">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold">Revenu total</h2>
        <div>
            {{ $this->getFilterAction() }}
        </div>
    </div>

    <div class="p-6 bg-white rounded-lg shadow">
        <div class="text-3xl font-bold text-gray-900">
            {{ $this->getStats()['revenue'] }}
        </div>
        <div class="text-sm text-gray-500">
            {{ $this->getStats()['description'] }}
        </div>
    </div>
</div>