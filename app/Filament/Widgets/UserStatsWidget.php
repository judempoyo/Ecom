<?php
namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = User::where('is_active', false)->count();
        $totalUsers = User::count();

        // Calculer la variation du nombre d'utilisateurs actifs par rapport au mois dernier
        $lastMonthActiveUsers = User::where('is_active', true)
            ->where('created_at', '>=', now()->subMonth())
            ->count();
        $activeUsersChange = $lastMonthActiveUsers > 0 ? (($activeUsers - $lastMonthActiveUsers) / $lastMonthActiveUsers) * 100 : 0;

        return [
            Stat::make('Utilisateurs actifs', $activeUsers)
                ->description($activeUsersChange >= 0 ? '+' . number_format($activeUsersChange, 2) . '%' : number_format($activeUsersChange, 2) . '%')
                ->descriptionIcon($activeUsersChange >= 0 ? 'heroicon-s-arrow-trending-up' : 'heroicon-s-arrow-trending-down')
                ->color($activeUsersChange >= 0 ? 'success' : 'danger')
                ->chart([7, 10, 15, 20, 25, 30, 35]) // Exemple de données pour un graphique
                ->icon('heroicon-s-user-group'),

            Stat::make('Utilisateurs inactifs', $inactiveUsers)
                ->description('Utilisateurs non actifs')
                ->descriptionIcon('heroicon-s-user-minus')
                ->color('danger')
                ->icon('heroicon-s-user-minus'),

            Stat::make('Total des utilisateurs', $totalUsers)
                ->description('Nombre total d\'utilisateurs')
                ->descriptionIcon('heroicon-s-users')
                ->color('warning')
                ->icon('heroicon-s-users'),
        ];
    }
}