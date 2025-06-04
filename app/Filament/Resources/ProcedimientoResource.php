<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProcedimientoResource\Pages;
use App\Filament\Resources\ProcedimientoResource\RelationManagers;
use App\Models\Procedimiento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use App\Models\Note;
use App\Models\Proceso;
use App\Models\Estatus;
use App\Models\User;
use App\Models\Firmas;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;

use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Actions\Action;



class ProcedimientoResource extends Resource
{
    protected static ?string $model = Procedimiento::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Gestión de calidad';

    protected static ?string $navigationLabel = 'Procedimientos';
   
    protected static ?int $navigationSort = 2;


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
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('NombreProcedimiento')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('IdProcesosP')
                            ->label('Proceso')
                            ->options(Proceso::all()->pluck('DescripcionProcesos', 'IdProcesos'))
                            ->required()
                            ->searchable(),

                        Forms\Components\TextInput::make('FolioProcedimientos')
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
                    ]),
                ]),
                Wizard\Step::make('Contenido del procedimiento')
                ->schema([
                    Forms\Components\Repeater::make('blocks')
                        ->addable(false)
                        ->deletable(false)
                        ->reorderable(false)
                        ->reorderable(false)
                        ->label('Contenido del procedimiento')
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
                                $blocks = $record->blocks()->get()->map(fn ($block) => [
                                    'titulo' => $block->titulo,
                                    'descripcion' => $block->descripcion,
                                ])->toArray();

                                $component->state($blocks);
                            } else {
                              
                                $notes = \App\Models\Note::where('section', 1)->orderBy('order')->get();

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
                                    $firmas = $record->procedimiento_firmas()->get()->map(function ($firma) {
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
                Tables\Columns\TextColumn::make('NombreProcedimiento')
                ->searchable(),
                Tables\Columns\TextColumn::make('proceso.DescripcionProcesos')
                ->label('Proceso')
                ->numeric()
                ->sortable(),
                Tables\Columns\TextColumn::make('FolioProcedimientos')
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
                Tables\Columns\TextColumn::make('procedimiento_firmas_count')
                    ->label('Firmas')
                    ->counts('procedimiento_firmas')
                    ->formatStateUsing(fn (string $state): string => "{$state}")
                    ->alignCenter()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListProcedimientos::route('/'),
            'create' => Pages\CreateProcedimiento::route('/create'),
            'view' => Pages\ViewProcedimiento::route('/{record}'),
            'edit' => Pages\EditProcedimiento::route('/{record}/edit'),
            'view-reporte' => Pages\ViewReporte::route('/{record}/view-reporte'),
        ];
    }


}
