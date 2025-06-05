<?php
namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStats extends BaseWidget
{
    //protected static ?string $heading = 'Commandes';

    protected function getStats(): array
    {
        // Filtres pour les périodes
        $ordersThisMonth = Order::whereMonth('created_at', now()->month)->count();
        $ordersThisYear = Order::whereYear('created_at', now()->year)->count();
        $ordersAllTime = Order::count();

        return [
            Stat::make('Ce mois-ci', $ordersThisMonth)
                ->description('Commandes passées ce mois-ci')
                ->descriptionIcon('heroicon-s-arrow-trending-up')
                ->color('success')
                ->icon('heroicon-s-shopping-cart'),

            Stat::make('Cette année', $ordersThisYear)
                ->description('Commandes passées cette année')
                ->descriptionIcon('heroicon-s-calendar')
                ->color('primary')
                ->icon('heroicon-s-shopping-cart'),

            Stat::make('Total', $ordersAllTime)
                ->description('Commandes passées depuis le début')
                ->descriptionIcon('heroicon-s-shopping-cart')
                ->color('warning')
                ->icon('heroicon-s-shopping-cart'),
        ];
    }
}