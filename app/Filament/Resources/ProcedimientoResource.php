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
use App\Models\ProcesoLinea;
use App\Models\Estatus;
use App\Models\User;
use App\Models\Firmas;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Illuminate\Support\Facades\DB;


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
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\TextInput::make('NombreProcedimiento')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('IdTipoProcesosP')
                            ->label('Tipo de proceso')
                            ->options(function ($record) {
                                // Si estamos editando un registro existente, mostrar solo el tipo específico del procedimiento
                                if ($record && $record->exists) {
                                    $tipoProceso = DB::table('procedimientos')
                                        ->join('proceso_linea', 'procedimientos.idProcesoLinea', '=', 'proceso_linea.idProcesoLinea')
                                        ->join('procesos', 'proceso_linea.idProceso', '=', 'procesos.IdProcesos')
                                        ->join('tipoprocesos', 'procesos.IdTipoProcesosP', '=', 'tipoprocesos.IdTipoProcesos')
                                        ->where('procedimientos.Idprocedimientos', $record->Idprocedimientos)
                                        ->select('tipoprocesos.IdTipoProcesos', 'tipoprocesos.DescripcionTipoProcesos')
                                        ->first();
                                    
                                    
                                    if ($tipoProceso) {
                                       
                                        return [$tipoProceso->IdTipoProcesos => $tipoProceso->DescripcionTipoProcesos];
                                    }
                                }
                                
                                // Si es un nuevo registro, mostrar todos los tipos de proceso
                                return \App\Models\Tipoproceso::all()->pluck('DescripcionTipoProcesos', 'IdTipoProcesos');
                            })
                            ->required()
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                $set('idProcesoLinea', null);
                                $set('FolioProcedimientos', null);
                            })
                            ->afterStateHydrated(function (Forms\Set $set, $record) {
                                if ($record && $record->exists) {
                                    $tipoProceso = DB::table('procedimientos')
                                        ->join('proceso_linea', 'procedimientos.idProcesoLinea', '=', 'proceso_linea.idProcesoLinea')
                                        ->join('procesos', 'proceso_linea.idProceso', '=', 'procesos.IdProcesos')
                                        ->join('tipoprocesos', 'procesos.IdTipoProcesosP', '=', 'tipoprocesos.IdTipoProcesos')
                                        ->where('procedimientos.Idprocedimientos', $record->Idprocedimientos)
                                        ->select('tipoprocesos.IdTipoProcesos')
                                        ->first();
                                    
                                    if ($tipoProceso) {
                                       
                                        $set('IdTipoProcesosP', $tipoProceso->IdTipoProcesos);
                                    }
                                }
                            })
                            ->searchable()
                            ->live()
                            ->disabled(fn ($record) => $record && $record->exists), // Deshabilitar en modo edición

                        Forms\Components\Select::make('idProcesoLinea')
                            ->label('Proceso')
                            ->options(function (Forms\Get $get, $record) {
                                $tipoProcesoId = $get('IdTipoProcesosP');
                
                                if (!$tipoProcesoId) {
                                    return [];
                                }
                                
                                // Si estamos editando, mostrar solo el proceso específico del procedimiento
                                if ($record && $record->exists) {
                                    $proceso = DB::table('procedimientos')
                                        ->join('proceso_linea', 'procedimientos.idProcesoLinea', '=', 'proceso_linea.idProcesoLinea')
                                        ->join('procesos', 'proceso_linea.idProceso', '=', 'procesos.IdProcesos')
                                        ->join('lineaproceso', 'proceso_linea.idLineaProceso', '=', 'lineaproceso.idLineaProceso')
                                        ->where('procedimientos.Idprocedimientos', $record->Idprocedimientos)
                                        ->select(
                                            'proceso_linea.idProcesoLinea',
                                            DB::raw("CONCAT(procesos.DescripcionProcesos,'- ',lineaproceso.nombreLineaProceso) AS nombre")
                                        )
                                        ->first();
                                    
                                    if ($proceso) {
                                        return [$proceso->idProcesoLinea => $proceso->nombre];
                                    }
                                }
                                
                                // Para nuevos registros, mostrar todos los procesos del tipo seleccionado
                                return DB::table('proceso_linea')
                                    ->join('procesos', 'proceso_linea.idProceso', '=', 'procesos.IdProcesos')
                                    ->join('lineaproceso', 'proceso_linea.idLineaProceso', '=', 'lineaproceso.idLineaProceso')
                                    ->where('procesos.IdTipoProcesosP', $tipoProcesoId)
                                    ->pluck( DB::raw("CONCAT(procesos.DescripcionProcesos,'- ',lineaproceso.nombreLineaProceso)  AS nombre")
                                    , 'proceso_linea.idProcesoLinea');
                            })
                            ->required()
                            ->searchable()
                            ->disabled(fn (Forms\Get $get, $record) => !$get('IdTipoProcesosP') || ($record && $record->exists))
                            ->afterStateHydrated(function (Forms\Set $set, $record) {
                                if ($record && $record->exists) {
                                    $proceso = DB::table('procedimientos')
                                        ->join('proceso_linea', 'procedimientos.idProcesoLinea', '=', 'proceso_linea.idProcesoLinea')
                                        ->where('procedimientos.Idprocedimientos', $record->Idprocedimientos)
                                        ->select('proceso_linea.idProcesoLinea')
                                        ->first();
                                    
                                    if ($proceso) {
                                     
                                        $set('idProcesoLinea', $proceso->idProcesoLinea);
                                    }
                                }
                            })
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                               
                                try {
                                    $procesoId = $get('idProcesoLinea');
                               
                                    if ($procesoId) {
                                        $proceso = \App\Models\ProcesoLinea::where('proceso_linea.idProcesoLinea', $procesoId)
                                        ->join('procesos', 'proceso_linea.idProceso', '=', 'procesos.IdProcesos')
                                        ->join('tipoprocesos', 'procesos.IdTipoProcesosP', '=', 'tipoprocesos.IdTipoProcesos')
                                        ->select('procesos.ClaveProcesos','tipoprocesos.DescripcionTipoProcesos AS tProceso')
                                        ->get();
                                        
                                        if ($proceso) {
                                            $set('FolioProcedimientos', $proceso[0]->ClaveProcesos.'-'.$proceso[0]->tProceso);
                                        }
                                    }
                                    
                                } catch (\Exception $e) {
                                    \Log::error('Error en afterStateUpdated idProcesoLinea: ' . $e->getMessage());
                                }
                            }),

                        Forms\Components\TextInput::make('FolioProcedimientos')
                            ->label('Folio del procedimiento')
                            ->required()
                            ->maxLength(255)
                            ->unique(column: 'FolioProcedimientos', ignoreRecord: true)
                            ->live()
                            ->disabled(function (Forms\Get $get) {
                                $isDisabled = !$get('idProcesoLinea');
                            }),

                        Forms\Components\TextInput::make('Version')
                            ->maxLength(255)
                            ->default(00)
                            ->live(),

                        Forms\Components\ToggleButtons::make('Idestatus')
                            ->label('Estatus')
                            ->columns(4)
                            ->required()
                            ->options(Estatus::orderBy('idestatus')->pluck('nombre', 'idestatus')->toArray())
                            ->disableOptionWhen(fn (string $value): bool => $value === '3', merge: true)    
                            ->disableOptionWhen(fn (string $value): bool => $value === '4', merge: true)
                            ->disableOptionWhen(fn (string $value): bool => $value === '5', merge: true)
                            ->default(1),


                            
                        Forms\Components\Select::make('Division')
                        ->multiple()
                        ->options([
                            'INDUSTRIAL' => 'INDUSTRIAL',
                            'CONSTRUCCION' => 'CONSTRUCCION',
                        ])
                        ->required()
                        ->searchable()
                        ->preload()
                        ->dehydrateStateUsing(fn ($state) => is_array($state) ? implode('/', $state) : $state)
                        ->afterStateHydrated(function (Forms\Set $set, $record) {
                            if ($record && $record->exists && $record->Division) {
                                $division = explode('/', $record->Division);
                                $set('Division', $division);
                            }
                        }),

                        Forms\Components\Select::make('UnidadNegocio')
                            ->label('Unidad de negocio')
                            ->multiple()
                            ->options([
                                'VT' => 'VT',
                                'ED' => 'ED',
                                'AG' => 'AG',
                                'CC' => 'CC',
                                'CORP' => 'CORP'
                            ])
                            ->required()
                            ->searchable()
                            ->preload()
                            ->dehydrateStateUsing(fn ($state) => is_array($state) ? implode('/', $state) : $state)
                            ->afterStateHydrated(function (Forms\Set $set, $record) {
                                if ($record && $record->exists && $record->UnidadNegocio) {
                                    $unidadNegocio = explode('/', $record->UnidadNegocio);
                                    $set('UnidadNegocio', $unidadNegocio);
                                }
                            }),

                        Forms\Components\DatePicker::make('fechaEmision')
                            ->label('Fecha de emisión'),

                        Forms\Components\TextInput::make('FolioCambios')
                            ->label('Folio de cambios')
                            ->unique(column: 'FolioCambios', ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('DescripcionCambios')
                            ->label('Descripción de cambios')
                            ->maxLength(255),
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
                Tables\Actions\Action::make('view-reporte')
                ->label('Documento')
                ->icon('heroicon-o-document-text')
                ->url(fn (Procedimiento $record) => ProcedimientoResource::getUrl('view-reporte', ['record' => $record]))
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
            'index' => Pages\ListProcedimientos::route('/'),
            'create' => Pages\CreateProcedimiento::route('/create'),
            'edit' => Pages\EditProcedimiento::route('/{record}/edit'),
            'view-reporte' => Pages\ViewReporte::route('/{record}/view-reporte'),
        ];
    }


}
