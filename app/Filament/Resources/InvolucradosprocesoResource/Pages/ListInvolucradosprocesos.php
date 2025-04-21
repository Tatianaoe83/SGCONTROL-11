<?php

namespace App\Filament\Resources\InvolucradosprocesoResource\Pages;

use App\Filament\Resources\InvolucradosprocesoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvolucradosprocesos extends ListRecords
{
    protected static string $resource = InvolucradosprocesoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
