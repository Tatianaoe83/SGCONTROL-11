<?php

namespace App\Filament\Resources\ProcedimientoResource\Pages;

use App\Filament\Resources\ProcedimientoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;


class EditProcedimiento extends EditRecord
{
    protected static string $resource = ProcedimientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
          
            Action::make('view-reporte')
            ->icon('heroicon-o-eye')
            ->url(fn () => route('procedimiento.view-reporte', ['record' => $this->record]))
            ->openUrlInNewTab(),
            
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
