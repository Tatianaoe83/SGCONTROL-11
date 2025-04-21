<?php

namespace App\Filament\Resources\InvolucradosprocesoResource\Pages;

use App\Filament\Resources\InvolucradosprocesoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInvolucradosproceso extends EditRecord
{
    protected static string $resource = InvolucradosprocesoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
