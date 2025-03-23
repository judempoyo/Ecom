<?php
namespace App\Filament\Widgets;

use App\Models\Order;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class MonthlyRevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Revenu mensuel';

    protected function getData(): array
    {
        // Utilise `laravel-trend` pour agréger les données
        $data = Trend::model(Order::class)
            ->between(
                start: now()->startOfYear(), // Début de l'année
                end: now()->endOfYear(),    // Fin de l'année
            )
            ->perMonth() // Agrégation par mois
            ->sum('total_amount'); // Somme des revenus par mois

        return [
            'datasets' => [
                [
                    'label' => 'Revenu',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#3b82f6', // Couleur du graphique
                    'fill' => false,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Type de graphique : ligne
    }
}