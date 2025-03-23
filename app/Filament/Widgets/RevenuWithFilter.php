<?php
namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RevenuWithFilter extends BaseWidget
{
    //protected static ?string $heading = 'Revenu total';

    protected function getStats(): array
    {
        // Filtres pour les périodes
        $revenueThisMonth = Order::whereMonth('created_at', now()->month)->sum('total_amount');
        $revenueThisYear = Order::whereYear('created_at', now()->year)->sum('total_amount');
        $revenueAllTime = Order::sum('total_amount');

        return [
            Stat::make('Ce mois-ci', number_format($revenueThisMonth, 2) . ' €')
                ->description('Revenu généré ce mois-ci')
                ->descriptionIcon('heroicon-s-arrow-trending-up')
                ->color('success')
                ->icon('heroicon-s-currency-dollar'),

            Stat::make('Cette année', number_format($revenueThisYear, 2) . ' €')
                ->description('Revenu généré cette année')
                ->descriptionIcon('heroicon-s-calendar')
                ->color('primary')
                ->icon('heroicon-s-currency-dollar'),

            Stat::make('Total', number_format($revenueAllTime, 2) . ' €')
                ->description('Revenu total depuis le début')
                ->descriptionIcon('heroicon-s-currency-dollar')
                ->color('warning')
                ->icon('heroicon-s-currency-dollar'),
        ];
    }
}
