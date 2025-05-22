<?php

namespace App\Filament\Resources\ProcedimientoResource\Pages;

use App\Filament\Resources\ProcedimientoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProcedimiento extends EditRecord
{
    protected static string $resource = ProcedimientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
        ];
    }
    protected function afterSave(): void
    {
        \App\Models\Procedimiento_block::where('procedimiento_id', $this->record->Idprocedimientos)->delete();

        foreach ($this->data['blocks'] as $block) {
            \App\Models\Procedimiento_block::create([
                'procedimiento_id' => $this->record->Idprocedimientos,
                'titulo' => $block['titulo'],
                'descripcion' => $block['descripcion'],
            ]);
        }
    }

}
