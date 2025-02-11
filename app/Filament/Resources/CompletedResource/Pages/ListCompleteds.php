<?php

namespace App\Filament\Resources\CompletedResource\Pages;

use App\Filament\Resources\CompletedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompleteds extends ListRecords
{
    protected static string $resource = CompletedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
