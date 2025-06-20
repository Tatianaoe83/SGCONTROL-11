<?php

namespace App\Filament\Resources\ProcesoResource\Pages;

use App\Filament\Resources\ProcesoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProceso extends EditRecord
{
    protected static string $resource = ProcesoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        
        $lineasActuales = \App\Models\ProcesoLinea::where('idProceso', $this->record->IdProcesos)
            ->pluck('idLineaProceso')
            ->toArray();
        
      
        $lineasNuevas = $this->data['idLineaProcesoP'] ?? [];
        
       
        $lineasAEliminar = array_diff($lineasActuales, $lineasNuevas);
        
     
        $lineasAAgregar = array_diff($lineasNuevas, $lineasActuales);
        
       
        if (!empty($lineasAEliminar)) {
            \App\Models\ProcesoLinea::where('idProceso', $this->record->IdProcesos)
                ->whereIn('idLineaProceso', $lineasAEliminar)
                ->delete();
        }
        
        foreach ($lineasAAgregar as $linea) {
            \App\Models\ProcesoLinea::create([
                'idProceso' => $this->record->IdProcesos,
                'idLineaProceso' => $linea,
            ]);
        }
    }
    
}
