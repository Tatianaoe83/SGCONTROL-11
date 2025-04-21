<?php

namespace App\Filament\Resources\FirmasProcedimientoResource\Pages;

use App\Filament\Resources\FirmasProcedimientoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFirmasProcedimiento extends EditRecord
{
    protected static string $resource = FirmasProcedimientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
