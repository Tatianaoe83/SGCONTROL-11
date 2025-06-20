<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ControlCambioResource\Pages;
use App\Filament\Resources\ControlCambioResource\RelationManagers;
use App\Models\ControlCambio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;    
use App\Models\Procesos;
use App\Models\Politica;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Procedimiento;

class ControlCambioResource extends Resource
{
    protected static ?string $model = ControlCambio::class;

    protected static ?string $navigationIcon = 'heroicon-m-chart-bar';

    protected static ?string $navigationLabel = 'Control de Cambios';

    protected static ?string $navigationGroup = 'Gestión de calidad';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Cambio')
                    ->description('Detalles principales del control de cambio')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('folioCambio')
                                    ->label('Folio del Cambio')
                                    ->reactive()
                                    ->required()
                                    ->maxLength(10)
                                    ->afterStateUpdated(function ($state, callable $set, Forms\Get $get) {
                                        if (strlen($state) >= 7) {
                                            $abrev = substr($state, 0, 2);
                                            $suma = substr($state, 2);
                                            $anio = substr($suma, 0, 2) . '000';
                                            $consecutivo = substr($suma, 2);
                                            $set('abrevCambio', $abrev);
                                            $set('anioCambio', $anio);
                                            $set('consecutivoCambio', $consecutivo);
                                            $set('sumaActual', $suma);
                                        } else {
                                            $set('abrevCambio', '');
                                            $set('anioCambio', '');
                                            $set('consecutivoCambio', '');
                                            $set('sumaActual', '');
                                        }
                                        $tElemento = $get('tElemento');
                                        if ($tElemento === 'Procedimiento' && $state) {
                                            $procedimiento = \App\Models\Procedimiento::where('FolioCambios', $state)->first();
                                            if ($procedimiento) {
                                                $set('tProceso', $procedimiento->proceso->tipoproceso->DescripcionTipoProcesos);
                                            } else {
                                                $set('tProceso', 'N/A');
                                            }
                                        } else {
                                            $set('tProceso', 'N/A');
                                        }
                                    }),
                                Forms\Components\TextInput::make('abrevCambio')
                                    ->label('Abreviatura')
                                    ->disabled()
                                    ->required()
                                    ->maxLength(15),
                                Forms\Components\TextInput::make('anioCambio')
                                    ->label('Año')
                                    ->disabled()
                                    ->required()
                                    ->numeric(),
                                Forms\Components\TextInput::make('consecutivoCambio')
                                    ->label('Consecutivo')
                                    ->disabled()
                                    ->required()
                                    ->numeric(),
                                Forms\Components\TextInput::make('sumaActual')
                                    ->label('Suma Actual')
                                    ->disabled()
                                    ->required()
                                    ->numeric(),
                                Forms\Components\Select::make('naturaleza')
                                    ->label('Naturaleza')
                                    ->options([
                                        'Auditoría interna' => 'Auditoría interna',
                                        'Auditoría externa' => 'Auditoría externa',
                                        'Revisión programada del SGC' => 'Revisión programada del SGC',
                                        'Propuesta de mejora' => 'Propuesta de mejora',
                                        'Por indicación de dirección' => 'Por indicación de dirección',
                                        'Actualización del elemento' => 'Actualización del elemento',
                                    ])
                                    ->required(),
                            ]),
                        Forms\Components\Textarea::make('descripcionNaturaleza')
                            ->label('Descripción de la Naturaleza')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('afectacion')
                            ->label('Afectación')
                            ->options([
                                'Nuevo' => 'Nuevo',
                                'Mejora' => 'Mejora',
                                'Eliminado' => 'Eliminado',
                            ]),
                           
                        Forms\Components\Textarea::make('redCambio')
                            ->label('Redacción del Cambio que sufrió')
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Detalles del Elemento')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('tElemento')
                                    ->label('Tipo de Elemento')
                                    ->live()
                                    ->options([
                                        'Procedimiento' => 'Procedimiento',
                                        'Proceso' => 'Proceso',
                                        'Política' => 'Política',
                                        'Manual' => 'Manual',
                                    ])
                                    ->required()
                                    ->afterStateUpdated(function ($state, callable $set, Forms\Get $get) {
                                        $folioCambio = $get('folioCambio');
                                        $tElemento = $get('tElemento');
                                        if ($tElemento === 'Procedimiento' && $folioCambio) {
                                            $procedimiento = Procedimiento::where('FolioCambios', $folioCambio)->first();
                                            if ($procedimiento) {
                                                $set('folioElemento', $procedimiento->Foliopoliticas);
                                                $set('tProceso', $procedimiento->proceso->tipoproceso->DescripcionTipoProcesos);
                                            } else {
                                                $set('folioElemento', 'N/A');
                                                $set('tProceso', 'N/A');
                                            }
                                        }elseif ($tElemento === 'Política' && $folioCambio) {
                                           
                                            $politica = Politica::where('FolioCambios', $folioCambio)->first();
                                            if ($politica) {
                                                $set('folioElemento', $politica->Foliopoliticas);
                                                $set('tProceso', 'N/A');
                                            } else {
                                                $set('folioElemento', 'N/A');
                                                $set('tProceso', 'N/A');
                                            }
                                        } else {
                                            $set('folioElemento', 'N/A');
                                            $set('tProceso', 'N/A');
                                        }
                                    }),
                                Forms\Components\TextInput::make('tProceso')
                                    ->label('Tipo de Proceso')
                                    ->required()
                                    ->maxLength(100)
                                    ->live()
                                    ->disabled(),
                                   
                                Forms\Components\TextInput::make('folioElemento')
                                    ->label('Folio del Elemento')
                                    ->disabled()
                                    ->live()  
                                    ->required()
                                    ->maxLength(255)
                                    ,
                                Forms\Components\TextInput::make('nomElemento')
                                    ->label('Nombre del Elemento')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('procElemento')
                                    ->label('Proceso del Elemento')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('procedPertenece')
                                    ->label('Procedimiento al que Pertenece')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ]),
                Forms\Components\Section::make('Seguimiento')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('lineAccion')
                                    ->label('Línea de Acción')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('responsableelemento')
                                    ->label('Responsable')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('idEstatus')
                                    ->label('Estatus')
                                    ->required()
                                    ->numeric(),
                                Forms\Components\TextInput::make('prioridad')
                                    ->label('Prioridad')
                                    ->maxLength(255),
                            ]),
                        Forms\Components\Textarea::make('detalleestatus')
                            ->label('Detalle del Estatus')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('seguimiento')
                            ->label('Seguimiento')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('historial')
                            ->label('Historial')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('folioCambio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('abrevCambio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('anioCambio')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('consecutivoCambio')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sumaActual')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('naturaleza')
                    ->searchable(),
                Tables\Columns\TextColumn::make('afectacion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tElemento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tProceso')
                    ->searchable(),
                Tables\Columns\TextColumn::make('folioElemento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomElemento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('procElemento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('procedPertenece')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lineAccion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('responsableelemento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('idEstatus')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('prioridad')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListControlCambios::route('/'),
            'create' => Pages\CreateControlCambio::route('/create'),
            'edit' => Pages\EditControlCambio::route('/{record}/edit'),
        ];
    }
}
