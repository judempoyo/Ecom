<?php
namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
   
    protected function getStats(): array
    {
        $totalProducts = Product::count();

        $totalStock = Product::sum('stock');
        $lowStockProducts = Product::where('stock', '<', 10)->count();
        

        return [
                       Stat::make('Total des produits', $totalProducts)
                ->description('Nombre total de produits')
                ->descriptionIcon('heroicon-s-cube')
                ->color('primary'),

                Stat::make('Total en stock', $totalStock)
                ->description('Quantité totale de produits en stock')
                ->descriptionIcon('heroicon-s-cube')
                ->color('primary')
                ->icon('heroicon-s-cube'),

            Stat::make('À réapprovisionner', $lowStockProducts)
                ->description('Produits avec un stock faible')
                ->descriptionIcon('heroicon-s-exclamation-circle')
                ->color('danger')
                ->icon('heroicon-s-exclamation-circle'),
                

        ];
    }
}