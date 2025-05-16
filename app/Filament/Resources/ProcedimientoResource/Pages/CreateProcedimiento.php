<?php

namespace App\Filament\Resources\ProcedimientoResource\Pages;

use App\Filament\Resources\ProcedimientoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProcedimiento extends CreateRecord
{
    protected static string $resource = ProcedimientoResource::class;

    protected array $creatingBlocks = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->creatingBlocks = $data['blocks'] ?? [];
        unset($data['blocks']);
        return $data;
    }

    protected function afterCreate(): void
    {
        $procedimientoId = $this->record->id; 

        foreach ($this->creatingBlocks as $block) {
            $this->record->blocks()->create([
                'titulo' => $block['titulo'],
                'descripcion' => $block['descripcion'],
                'procedimiento_id' => $procedimientoId,
            ]);
        }
    }
}