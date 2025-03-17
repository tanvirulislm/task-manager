<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TaskWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Stat::make('Pending', Task::where('status', 'pending')->count())
            ->description('Total pending tasks')
            ->descriptionIcon('heroicon-o-clock')
            ->color('warning'),

        Stat::make('In Progress', Task::where('status', 'in_progress')->count())
            ->description('Tasks currently in progress')
            ->descriptionIcon('heroicon-o-arrow-path')
            ->color('primary'),

        Stat::make('Completed', Task::where('status', 'completed')->count())
            ->description('Tasks completed')
            ->descriptionIcon('heroicon-o-check-badge')
            ->color('success'),
        ];
    }
}
