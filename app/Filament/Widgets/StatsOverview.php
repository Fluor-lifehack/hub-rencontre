<?php

namespace App\Filament\Widgets;

use App\Models\Country;
use App\Models\Plan;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserMatch;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Utilisateurs', User::count())
                ->description('Total des utilisateurs inscrits')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Profils', Profile::count())
                ->description('Profils créés')
                ->descriptionIcon('heroicon-m-user-circle')
                ->color('info'),

            Stat::make('Pays', Country::count())
                ->description('Pays disponibles')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('warning'),

            Stat::make('Plans', Plan::count())
                ->description('Plans d\'abonnement')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('primary'),

            Stat::make('Matches', UserMatch::count())
                ->description('Correspondances créées')
                ->descriptionIcon('heroicon-m-heart')
                ->color('danger'),
        ];
    }
}
