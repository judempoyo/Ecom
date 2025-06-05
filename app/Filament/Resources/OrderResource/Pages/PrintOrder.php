<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Resources\Pages\Page;

class PrintOrder extends Page
{
    protected static string $resource = OrderResource::class;
    protected static string $view = 'filament.resources.order-resource.pages.print-order';

    public Order $record;

    protected function getViewData(): array
    {
        return [
            'record' => $this->record,
        ];
    }

    public function mount(Order $record): void
    {
        $this->record = $record;
    }
}