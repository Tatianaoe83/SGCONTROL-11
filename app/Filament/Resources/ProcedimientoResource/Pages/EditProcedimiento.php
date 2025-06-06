<?php

namespace App\Filament\Resources\ProcedimientoResource\Pages;

use App\Filament\Resources\ProcedimientoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use App\Models\Procedimiento;

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
