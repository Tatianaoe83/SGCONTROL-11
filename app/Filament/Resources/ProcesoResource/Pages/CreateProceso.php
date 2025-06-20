<?php

namespace App\Filament\Resources\ProcesoResource\Pages;

use App\Filament\Resources\ProcesoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Proceso;
use App\Models\ProcesoLinea;

class CreateProceso extends CreateRecord
{
    protected static string $resource = ProcesoResource::class;

    protected array $creatingLineas = [];

    public function mutateFormDataBeforeCreate(array $data): array   
    {
        $this->creatingLineas = $data['idLineaProcesoP'] ?? [];
        unset($data['idLineaProcesoP']);
        return $data;
    }

    public function afterCreate()
    {
        foreach ($this->creatingLineas as $linea) {
            ProcesoLinea::create([
                'idProceso' => $this->record->IdProcesos,
                'idLineaProceso' => $linea,
            ]);
        }
       
    }
}
