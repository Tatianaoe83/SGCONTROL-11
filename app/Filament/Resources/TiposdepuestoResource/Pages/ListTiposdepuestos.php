<?php

namespace App\Filament\Resources\TiposdepuestoResource\Pages;

use App\Filament\Resources\TiposdepuestoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTiposdepuestos extends ListRecords
{
    protected static string $resource = TiposdepuestoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
