<?php

namespace App\Filament\Resources\TiposdepuestoResource\Pages;

use App\Filament\Resources\TiposdepuestoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTiposdepuesto extends EditRecord
{
    protected static string $resource = TiposdepuestoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
