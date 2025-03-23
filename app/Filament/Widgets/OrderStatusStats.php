<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStatusStats extends BaseWidget
{
    //protected static ?string $heading = 'Statistiques des commandes';

    protected function getStats(): array
    {
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        return [
            Stat::make('En attente', $pendingOrders)
                ->description('Commandes en attente de traitement')
                ->descriptionIcon('heroicon-s-clock')
                ->color('warning')
                ->icon('heroicon-s-clock'),

            Stat::make('Expédiées', $completedOrders)
                ->description('Commandes expédiées')
                ->descriptionIcon('heroicon-s-truck')
                ->color('success')
                ->icon('heroicon-s-truck'),

            Stat::make('Annulées', $cancelledOrders)
                ->description('Commandes annulées')
                ->descriptionIcon('heroicon-s-x-circle')
                ->color('danger')
                ->icon('heroicon-s-x-circle'),
        ];
    }
}