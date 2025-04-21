<?php

namespace App\Filament\Resources\FirmasProcedimientoResource\Pages;

use App\Filament\Resources\FirmasProcedimientoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFirmasProcedimientos extends ListRecords
{
    protected static string $resource = FirmasProcedimientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
