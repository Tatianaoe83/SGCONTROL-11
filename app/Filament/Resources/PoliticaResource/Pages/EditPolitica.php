<?php

namespace App\Filament\Resources\PoliticaResource\Pages;

use App\Filament\Resources\PoliticaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use App\Models\Politica;

class EditPolitica extends EditRecord
{
    protected static string $resource = PoliticaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view-reporte-politica')
            ->label('Documento')
            ->icon('heroicon-o-document-text')
            ->url(fn (Politica $record) => PoliticaResource::getUrl('view-reporte-politica', ['record' => $record]))
            ->openUrlInNewTab(),
        ];
    }
    protected function afterSave(): void
    {
        \App\Models\Politica_block::where('politica_id', $this->record->Idpoliticas)->delete();
        \App\Models\Politica_firmas::where('Idpoliticas', $this->record->Idpoliticas)->delete();

        foreach ($this->data['firmas'] as $firma) {
            \App\Models\Politica_firmas::create([
                'Idpoliticas' => $this->record->Idpoliticas,
                'idUsuario' => $firma['idUsuario'],
                'IdFirmas' => $firma['IdFirmas'],
            ]);
        }

        foreach ($this->data['blocks'] as $block) {
            \App\Models\Politica_block::create([
                'politica_id' => $this->record->Idpoliticas,
                'titulo' => $block['titulo'],
                'descripcion' => $block['descripcion'],
            ]);
        }
    }
}
