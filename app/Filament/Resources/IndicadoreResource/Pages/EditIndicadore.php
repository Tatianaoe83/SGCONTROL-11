<?php

namespace App\Filament\Resources\IndicadoreResource\Pages;

use App\Filament\Resources\IndicadoreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIndicadore extends EditRecord
{
    protected static string $resource = IndicadoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
