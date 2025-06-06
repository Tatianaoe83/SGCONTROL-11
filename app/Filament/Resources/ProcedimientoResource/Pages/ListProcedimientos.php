<?php

namespace App\Filament\Resources\ProcedimientoResource\Pages;

use App\Filament\Resources\ProcedimientoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProcedimientos extends ListRecords
{
    protected static string $resource = ProcedimientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\Action::make('reporte')
                ->label('Reporte')
                ->icon('heroicon-o-document-text')
                ->url(fn ($record) => route('filament.admin.resources.procedimientos.view-reporte', ['record' => $record->getKey()]))
                ->openUrlInNewTab(),
        ];
    }
}
