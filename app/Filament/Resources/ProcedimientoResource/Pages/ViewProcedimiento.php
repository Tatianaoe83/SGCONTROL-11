<?php

namespace App\Filament\Resources\ProcedimientoResource\Pages;

use App\Filament\Resources\ProcedimientoResource;
use Filament\Actions;
use Filament\Actions\Action; 
use Filament\Resources\Pages\ViewRecord;

class ViewProcedimiento extends ViewRecord
{
    protected static string $resource = ProcedimientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Action::make('ver_reporte')
                ->label('Ver reporte')
                ->icon('heroicon-o-eye')
                ->url(fn () => route('filament.resources.procedimientos.view-reporte', ['record' => $this->record]))
                ->openUrlInNewTab(),
        ];
    }
}


