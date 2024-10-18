<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserCountWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Utilizatori', User::count())
                ->description('Numar total de utilizatori')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
        ];
    }
}