<?php

namespace App\Filament\Resources\ProcedimientoResource\Pages;

use App\Filament\Resources\ProcedimientoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use App\Models\Procedimiento;
use App\Models\ProcesoLinea;
use App\Models\Estatus;
use App\Models\ControlCambio;

class EditProcedimiento extends EditRecord
{
    protected static string $resource = ProcedimientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view-reporte')
                ->label('Documento')
                ->icon('heroicon-o-document-text')
                ->url(fn (Procedimiento $record) => ProcedimientoResource::getUrl('view-reporte', ['record' => $record]))
                ->openUrlInNewTab(),
        ];
    }
    protected function afterSave(): void
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

        \App\Models\Procedimiento_block::where('procedimiento_id', $this->record->Idprocedimientos)->delete();
        \App\Models\Procedimiento_firmas::where('Idprocedimientos', $this->record->Idprocedimientos)->delete();

        foreach ($this->data['blocks'] as $block) {
            \App\Models\Procedimiento_block::create([
                'procedimiento_id' => $this->record->Idprocedimientos,
                'titulo' => $block['titulo'],
                'descripcion' => $block['descripcion'],
            ]);
        }

        foreach ($this->data['firmas'] as $firma) {
            \App\Models\Procedimiento_firmas::create([
                'Idprocedimientos' => $this->record->Idprocedimientos,
                'idUsuario' => $firma['idUsuario'],
                'IdFirmas' => $firma['IdFirmas'],
            ]);
        }
    }

}
