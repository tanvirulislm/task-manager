<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Task;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\IconPosition;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TaskResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $modelLabel = ('Task');

    protected static ?string $navigationGroup = 'Task Management';

    protected static  ?string $navigationLabel = ('Tasks');

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
    $incompleteTaskCount = Task::where('status', '!=', 'completed')->count();
    return $incompleteTaskCount > 0 ? (string) $incompleteTaskCount : null;
    }

    public static function query()
    {
        return Task::where('status', '!=', 'completed');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category_id')
                ->label('Select Category')
                ->placeholder('Select Category')
                ->relationship('category', 'name')
                ->searchable()
                ->preload()
                ->live()
                ->required(),
                TextInput::make('name')
                    ->label('Task Name')
                    ->required()
                    ->placeholder('Enter the task name'),
                Textarea::make('description')
                    ->label('Description')
                    ->columnSpan(2)
                    ->placeholder('Enter the description'),
                DatePicker::make('due_date')
                    ->required()
                    ->native(false)
                    ->rule('after_or_equal:today')
                    ->placeholder('Enter the due date'),
                Select::make('priority')
                    ->label('Priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                    ])
                    ->default('medium')
                    ->searchable()
                    ->live()
                    ->preload()
                    ->required()
                    ->placeholder('Enter the priority'),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                    ])
                    ->default('pending')
                    ->searchable()
                    ->live()
                    ->preload()
                    ->label('Status')
                    ->required()
                    ->placeholder('Enter the status'),
                DatePicker::make('completed_at')
                    ->label('Completed At')
                    ->native(false)
                    ->placeholder('Enter the completed at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->query(static::query())
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Task Status')
                    ->badge()
                    ->sortable()
                    ->searchable()
                    ->colors([
                        'danger' => 'pending',
                        'warning' => 'in_progress',
                        'success' => 'completed',
                    ])
                    ->icon(fn ($state) => match ($state) {
                        'pending' => 'heroicon-o-clock',
                        'in_progress' => 'heroicon-o-arrow-path',
                        'completed' => 'heroicon-o-check-badge',
                        default => null,
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        default => $state}),
                Tables\Columns\TextColumn::make('description')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('priority')
            ->label('Priority')
            ->options([
                'low' => 'Low',
                'medium' => 'Medium',
                'high' => 'High',
            ])
            ->searchable()
            ])
            ->actions([
                Tables\Actions\Action::make('Complete')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(fn (Task $record) => $record->update(['is_completed' => true, 'status' => 'completed', 'completed_at' => now(),]))
                ->visible(fn (Task $record) => !$record->is_completed),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('Mark Completed')
                        ->icon('heroicon-o-clipboard-document-check')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['is_completed' => true, 'status' => 'completed', 'completed', 'completed_at' => now()])),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
