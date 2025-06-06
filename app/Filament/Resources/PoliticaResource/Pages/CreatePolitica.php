<?php

namespace App\Filament\Resources\PoliticaResource\Pages;

use App\Filament\Resources\PoliticaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePolitica extends CreateRecord
{
    protected static string $resource = PoliticaResource::class;

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
        $politicaId = $this->record->getKey(); // o $this->record->Idpoliticas

  

    foreach ($this->creatingBlocks as $block) {
        $this->record->blocksPolitica()->create([
            'titulo' => $block['titulo'],
            'descripcion' => $block['descripcion'],
            'politica_id' => $politicaId,
        ]);
    }

    foreach ($this->creatingFirmas as $firma) {
        $this->record->politica_firmas()->create([
            'idUsuario' => $firma['idUsuario'],
            'IdFirmas' => $firma['IdFirmas'],
            'Idpoliticas' => $politicaId,
        ]);
    }

    }
}