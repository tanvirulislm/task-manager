<?php

namespace App\Filament\Resources\CompletedResource\Pages;

use App\Filament\Resources\CompletedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompleted extends EditRecord
{
    protected static string $resource = CompletedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
