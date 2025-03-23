<?php
namespace App\Filament\Widgets;

use App\Models\OrderItem;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\BarChartWidget;

class BestSellingProducts extends BarChartWidget
{
    protected static ?string $heading = 'Produits les plus vendus';

    protected function getData(): array
    {
        // Agrégation des produits les plus vendus
        $orderItems = OrderItem::selectRaw('product_id, sum(quantity) as total_quantity')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->with('product')
            ->get();

        $labels = $orderItems->pluck('product.name')->toArray();
        $data = $orderItems->pluck('total_quantity')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Quantité vendue',
                    'data' => $data,
                    'backgroundColor' => ['#4ade80', '#fbbf24', '#60a5fa', '#f87171', '#a78bfa'],
                ],
            ],
        ];
    }
}