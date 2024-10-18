<?php

namespace App\Filament\Widgets;

use App\Models\Story;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StoryCountWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Povesti Generate', Story::count())
                ->description('Numar total de povesti generate')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('success'),
        ];
    }
}