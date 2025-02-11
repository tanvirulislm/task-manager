<?php

namespace App\Filament\Resources\TaskResource\Pages;

use Filament\Actions;
use App\Filament\Resources\TaskResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateTask extends CreateRecord
{
    protected static string $resource = TaskResource::class;

    protected function getCreatedNotification(): ?Notification{
        return Notification::make()
            ->success()
            ->title('Task Created')
            ->body('The task has been created successfully.');
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index'); // Redirect to Task List
    }
}
