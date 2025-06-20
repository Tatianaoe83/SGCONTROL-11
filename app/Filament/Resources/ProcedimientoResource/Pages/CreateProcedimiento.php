<?php

namespace App\Filament\Resources\ProcedimientoResource\Pages;

use App\Filament\Resources\ProcedimientoResource;
use Filament\Actions;   
use App\Models\ControlCambio;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use App\Models\ProcesoLinea;
use App\Models\Estatus;

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
        $folioCambio = $this->record->FolioCambios;
        $abrev = substr($this->record->FolioCambios, 0, 2);
        $suma = substr($this->record->FolioCambios, 2);
        $anio = substr($suma, 0, 2) . '000';
        $consecutivo = substr($suma, 2);
        $felemento = $this->record->FolioProcedimientos;
        $nElemento = $this->record->NombreProcedimiento;

        $procesosL = ProcesoLinea::select('procesos.DescripcionProcesos','lineaproceso.nombreLineaProceso','lineaproceso.responsableProceso','tipoprocesos.DescripcionTipoProcesos AS tProceso' )
        ->join('procesos', 'proceso_linea.idProceso', '=', 'procesos.IdProcesos')
        ->join('lineaproceso', 'proceso_linea.idLineaProceso', '=', 'lineaproceso.idLineaProceso')
        ->join('tipoprocesos', 'procesos.IdTipoProcesosP', '=', 'tipoprocesos.IdTipoProcesos')
        ->where('proceso_linea.idProcesoLinea', $this->record->idProcesoLinea)
        ->first();

        $estatus = Estatus::where('idestatus', $this->record->Idestatus)->first();
        $procedimientoId = $this->record->getKey(); // o $this->record->Idprocedimientos

        $controlCambio = ControlCambio::create([
            'folioCambio' => $folioCambio,
            'abrevCambio' => $abrev,
            'anioCambio' => $anio,
            'consecutivoCambio' => $consecutivo,
            'sumaActual' => $suma,
            'tElemento' => 'Procedimiento',
            'procElemento' => $procesosL->DescripcionProcesos,
            'folioElemento' => $felemento,
            'nomElemento' => $nElemento,
            'procedPertenece' => 'N/A',
            'tProceso' => $procesosL->tProceso,
            'responsableelemento' => $procesosL->responsableProceso,
            'lineAccion' => $procesosL->nombreLineaProceso,
            'Estatus' => $estatus->nombre,

        ]);

  

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