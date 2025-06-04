<?php

namespace App\Filament\Resources\ControlCambioResource\Pages;

use App\Filament\Resources\ControlCambioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditControlCambio extends EditRecord
{
    protected static string $resource = ControlCambioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
