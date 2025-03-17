<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class HighPriorityTasksWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {

        $query = Task::where('priority', 'high')
            ->where('status', '!=', 'completed')
            ->latest();

        if ($query->count() == 0) {
            $query = Task::where('is_completed', false)
                ->orderBy('due_date', 'asc');
        }
        return $table
            ->query($query)
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                ->label('Category')
                ->sortable(),
                Tables\Columns\TextColumn::make('name')
                ->label('Name')
                ->searchable(),
            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->sortable()
                ->color(fn ($state) => match ($state) {
                    'pending' => 'danger',
                    'in_progress' => 'warning',
                    'completed' => 'success',
                })
                ->icon(fn ($state) => match ($state) {
                    'pending' => 'heroicon-o-clock',
                    'in_progress' => 'heroicon-o-arrow-path',
                    'completed' => 'heroicon-o-check-badge',
                })
                ->formatStateUsing(fn ($state) => match ($state) {
                    'pending' => 'Pending',
                    'in_progress' => 'In Progress',
                    'completed' => 'Completed',
                    default => $state}),
            
            Tables\Columns\TextColumn::make('due_date')
                ->label('Due Date')
                ->date()
                ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('Complete')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(fn (Task $record) => $record->update(['is_completed' => true, 'status' => 'completed', 'completed_at' => now(),]))
                ->visible(fn (Task $record) => !$record->is_completed),
            ]);
    }
}
