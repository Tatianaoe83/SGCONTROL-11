<?php

namespace App\Filament\Pages;

use App\Models\Note;
use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;

class Plantillasgeneradas extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static string $view = 'filament.pages.plantillasgeneradas';


    protected static ?string $title = 'Plantillas generales';

    protected static ?string $navigationIcon = 'heroicon-s-table-cells';


    protected static ?string $navigationGroup = 'Gestión de calidad';

    protected static ?string $navigationLabel = 'Plantillas generales';

    protected static ?int $navigationSort = 1;

    public int $section = 1;

    public function setSection(int $section)
    {
        $this->section = $section;
    }

    protected function getTableQuery()
    {
        return Note::query()
            ->where('section', $this->section)
            ->orderBy('order');
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('order')->label('Orden'),
            TextColumn::make('content')->label('Contenido')->limit(50),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('subir')
                ->label('↑')
                ->action(function (Note $record) {
                    $prev = Note::where('section', $record->section)
                        ->where('order', '<', $record->order)
                        ->orderByDesc('order')->first();

                    if ($prev) {
                        [$record->order, $prev->order] = [$prev->order, $record->order];
                        $record->save();
                        $prev->save();
                    }
                }),

            Action::make('bajar')
                ->label('↓')
                ->action(function (Note $record) {
                    $next = Note::where('section', $record->section)
                        ->where('order', '>', $record->order)
                        ->orderBy('order')->first();

                    if ($next) {
                        [$record->order, $next->order] = [$next->order, $record->order];
                        $record->save();
                        $next->save();
                    }
                }),

            Action::make('editar')
                ->label('Editar')
                ->form([
                    
                    Textarea::make('content')->required(),
                    Select::make('section')
                        ->options([1 => 'Procedimientos', 2 => 'Políticas'])
                        ->required(),
                ])
                ->fillForm(fn (Note $record) => $record->toArray())
                ->action(fn (array $data, Note $record) => $record->update($data)),

            DeleteAction::make(),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('crear')
                ->label('Nueva Nota')
                ->form([
                    Textarea::make('content')->required(),
                    Select::make('section')
                        ->options([1 => 'Procedimientos', 2 => 'Políticas'])
                        ->required(),
                ])
                ->action(function (array $data) {
                    $max = Note::where('section', $data['section'])->max('order') ?? 0;

                    Note::create([
                        'content' => $data['content'],
                        'section' => $data['section'],
                        'order' => $max + 1,
                    ]);
                }),
        ];
    }
}
