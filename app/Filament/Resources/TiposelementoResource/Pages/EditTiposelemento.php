<?php

namespace App\Filament\Resources\TiposelementoResource\Pages;

use App\Filament\Resources\TiposelementoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTiposelemento extends EditRecord
{
    protected static string $resource = TiposelementoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
