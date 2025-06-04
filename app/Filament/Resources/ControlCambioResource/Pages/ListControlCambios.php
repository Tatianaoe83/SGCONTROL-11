<?php

namespace App\Filament\Resources\ControlCambioResource\Pages;

use App\Filament\Resources\ControlCambioResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListControlCambios extends ListRecords
{
    protected static string $resource = ControlCambioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
