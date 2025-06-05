<?php

namespace App\Filament\Resources\OrderResource\Pages;


use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Resources\Pages\Page;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions;

class ViewOrder extends Page
{
    protected static string $resource = OrderResource::class;
    protected static string $view = 'filament.resources.order-resource.pages.view-order';

    public Order $record;

    protected function getActions(): array
    {
        return [
            \Filament\Actions\Action::make('print')
                ->label('Imprimer la facture')
                ->icon('heroicon-o-printer')
                ->color('primary')
                ->url(fn () => route('filament.admin.resources.orders.print', $this->record))
                ->openUrlInNewTab(),
            \Filament\Actions\EditAction::make(),
            //\Filament\Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return "Facture #{$this->record->id}";
    }
}

