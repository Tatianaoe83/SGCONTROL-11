<?php

namespace App\Filament\Resources\ProcedimientoResource\Pages;

use App\Filament\Resources\ProcedimientoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProcedimiento extends CreateRecord
{
    protected static string $resource = ProcedimientoResource::class;

    protected array $creatingBlocks = [];
    protected array $creatingFirmas = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->creatingBlocks = $data['blocks'] ?? [];
        unset($data['blocks']);
        $this->creatingFirmas = $data['firmas'] ?? [];
        unset($data['firmas']);
        return $data;
    }

    protected function afterCreate(): void
    {
        $procedimientoId = $this->record->getKey(); // o $this->record->Idprocedimientos

    \Log::info($this->creatingFirmas);
    \Log::info($procedimientoId);

    foreach ($this->creatingBlocks as $block) {
        $this->record->blocks()->create([
            'titulo' => $block['titulo'],
            'descripcion' => $block['descripcion'],
            'procedimiento_id' => $procedimientoId,
        ]);
    }

    foreach ($this->creatingFirmas as $firma) {
        $this->record->procedimiento_firmas()->create([
            'idUsuario' => $firma['idUsuario'],
            'IdFirmas' => $firma['IdFirmas'],
            'Idprocedimientos' => $procedimientoId,
        ]);
    }

    }
}