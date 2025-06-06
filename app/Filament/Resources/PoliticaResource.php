<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PoliticaResource\Pages;
use App\Filament\Resources\PoliticaResource\RelationManagers;
use App\Models\Politica;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use App\Models\Note;
use App\Models\Estatus;
use App\Models\User;
use App\Models\Firmas;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;

use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Actions\Action;



class PoliticaResource extends Resource
{
    protected static ?string $model = Politica::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Gestión de calidad';

    protected static ?string $navigationLabel = 'Políticas';
   
    protected static ?int $navigationSort = 3;


    public static function form(Form $form): Form
    {
    
        return $form->schema([
            Wizard::make()
            ->columnSpan('full')
            ->skippable()
            ->nextAction(
                fn (Action $action) => $action->label('Siguiente paso'),
            )
            ->previousAction(
                fn (Action $action) => $action->label('Anterior'),
            )
            ->schema([
                Wizard\Step::make('Información general')
                ->schema([
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\TextInput::make('Nombrepolitica')
                            ->label('Nombre de la política')
                            ->required()
                            ->maxLength(255),

                            Forms\Components\TextInput::make('NombreArea')
                            ->label('Área')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('Foliopoliticas')
                            ->label('Folio de la política')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('Version')
                            ->maxLength(255)
                            ->default(1),

                        Forms\Components\ToggleButtons::make('Idestatus')
                            ->label('Estatus')
                            ->columns(4)
                            ->required()
                            ->options(Estatus::orderBy('idestatus')->pluck('nombre', 'idestatus')->toArray()),


                        Forms\Components\TextInput::make('Division')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('UnidadNegocio')
                            ->label('Unidad de negocio')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\DatePicker::make('fechaEmision')
                            ->label('Fecha de emisión'),

                        Forms\Components\TextInput::make('FolioCambios')
                            ->label('Folio de cambios')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('DescripcionCambios')
                            ->label('Descripción de cambios')
                            ->maxLength(255),
                    ]),
                ]),
                Wizard\Step::make('Contenido de la política')
                ->schema([
                    Forms\Components\Repeater::make('blocks')
                        ->addable(false)
                        ->deletable(false)
                        ->reorderable(false)
                        ->reorderable(false)
                        ->label('Contenido de la política')
                        ->schema([
                            Forms\Components\Hidden::make('titulo'),
                            Forms\Components\Placeholder::make('header')
                                ->label('')
                                ->content(fn ($get) => $get('titulo')),
                            TinyEditor::make('descripcion')
                                ->label('')
                                ->required(),
                        ])
                        ->afterStateHydrated(function (Forms\Components\Repeater $component, $state, $record) {
                            if ($record && $record->exists) {
                                $blocks = $record->blocksPolitica()->get()->map(fn ($block) => [
                                    'titulo' => $block->titulo,
                                    'descripcion' => $block->descripcion,
                                ])->toArray();

                                $component->state($blocks);
                            } else {
                              
                                $notes = \App\Models\Note::where('section', 2)->orderBy('order')->get();

                                $component->state(
                                    collect($notes)->map(fn ($note) => [
                                        'titulo' => $note->order . '. ' . $note->content,
                                        'descripcion' => '',
                                    ])->toArray()
                                );
                            }
                        }),
                ]),
                Wizard\Step::make('Firmas')
                    ->schema([
                        Forms\Components\Repeater::make('firmas')
                            ->schema([
                                Forms\Components\Select::make('idUsuario')
                                    ->label('Usuario')
                                    ->options(User::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->required(),
                                Forms\Components\Select::make('IdFirmas')
                                    ->label('Asignación')
                                    ->options(Firmas::all()->pluck('nombre', 'idfirmas'))
                                    ->searchable()
                                    ->required(),
                            ])
                            ->reorderable(false)
                            ->addActionLabel('Agregar')
                            ->columns(2)
                            ->afterStateHydrated(function ($component, $state, $record) {
                                if ($record && $record->exists) {
                                    $firmas = $record->politica_firmas()->get()->map(function ($firma) {
                                        return [
                                            'idUsuario' => $firma->idUsuario,
                                            'IdFirmas' => $firma->IdFirmas,
                                        ];
                                    })->toArray();
                                    $component->state($firmas);
                                }
                            }),
                    ]),
            ]),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Nombrepolitica')
                ->searchable(),
                Tables\Columns\TextColumn::make('NombreArea')
                ->label('Área')
                ->sortable(),
                Tables\Columns\TextColumn::make('Foliopoliticas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Version')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Idestatus')
                    ->label('Estatus')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Estatus::find($state)?->nombre ?? '')
                    ->color(fn ($state) => match ($state) {
                        1 => 'gray',    // Proceso
                        2 => 'info',    // Liberado
                        3 => 'warning', // Revision
                        4 => 'primary', // Firmas
                        5 => 'success', // Portal
                        6 => 'danger',  // Detenido
                        7 => 'danger',  // Cerrado
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('FolioCambios')
                    ->label('Folio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('politica_firmas_count')
                    ->label('Firmas')
                    ->counts('politica_firmas')
                    ->formatStateUsing(fn (string $state): string => "{$state}")
                    ->alignCenter()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('view-reporte')
                ->label('Documento')
                ->icon('heroicon-o-document-text')
                ->url(fn (Politica $record) => PoliticaResource::getUrl('view-reporte-politica', ['record' => $record]))
                ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
               
            ]);
    }

    public static function getRelations(): array
    {   
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPoliticas::route('/'),
            'create' => Pages\CreatePolitica::route('/create'),
            'edit' => Pages\EditPolitica::route('/{record}/edit'),
            'view-reporte-politica' => Pages\ViewReportePolitica::route('/{record}/view-reporte-politica'),
        ];
    }


}
