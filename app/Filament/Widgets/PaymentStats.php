<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PaymentStats extends BaseWidget
{
    //protected static ?string $heading = 'Statistiques des paiements';

    protected function getStats(): array
    {
        $successfulPayments = Payment::where('status', 'completed')->count();
        $failedPayments = Payment::where('status', 'failed')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();

        return [
            Stat::make('Réussis', $successfulPayments)
                ->description('Paiements réussis')
                ->descriptionIcon('heroicon-s-check-circle')
                ->color('success')
                ->icon('heroicon-s-check-circle'),

            Stat::make('Échoués', $failedPayments)
                ->description('Paiements échoués')
                ->descriptionIcon('heroicon-s-x-circle')
                ->color('danger')
                ->icon('heroicon-s-x-circle'),

            Stat::make('En attente', $pendingPayments)
                ->description('Paiements en attente')
                ->descriptionIcon('heroicon-s-clock')
                ->color('warning')
                ->icon('heroicon-s-clock'),
        ];
    }
}