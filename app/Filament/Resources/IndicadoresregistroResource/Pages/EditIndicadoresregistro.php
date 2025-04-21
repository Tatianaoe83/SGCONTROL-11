<?php

namespace App\Filament\Resources\IndicadoresregistroResource\Pages;

use App\Filament\Resources\IndicadoresregistroResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIndicadoresregistro extends EditRecord
{
    protected static string $resource = IndicadoresregistroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
