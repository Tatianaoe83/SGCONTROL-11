<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProcesoResource\Pages;
use App\Filament\Resources\ProcesoResource\RelationManagers;
use App\Models\Proceso;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\LineaProceso;
use App\Models\ProcesoLinea;
use App\Models\TipoProceso;

class ProcesoResource extends Resource
{
    protected static ?string $model = Proceso::class;

    protected static ?string $navigationIcon = 'heroicon-c-arrow-path-rounded-square';

    protected static ?string $navigationLabel = 'Procesos';

    protected static ?string $navigationGroup = 'Organización';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Proceso')
                    ->schema([
                        Forms\Components\TextInput::make('ClaveProcesos')
                            ->required()
                            ->maxLength(7),
                        Forms\Components\TextInput::make('DescripcionProcesos')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\Select::make('IdTipoProcesosP')
                            ->label('Tipo de proceso')
                            ->options(TipoProceso::all()->pluck('DescripcionTipoProcesos', 'IdTipoProcesos'))
                            ->required(),
                    ]),
                Forms\Components\Section::make('Líneas del Proceso')
                    ->schema([
                        Forms\Components\Select::make('idLineaProcesoP')
                            ->label('Línea de proceso')
                            ->options(function () {
                                return LineaProceso::query()
                                    ->selectRaw("idLineaProceso, CONCAT(nombreLineaProceso, ' - ', responsableProceso) as nombre_completo")
                                    ->pluck('nombre_completo', 'idLineaProceso');
                            })
                            ->required()
                            ->afterStateHydrated(function (Forms\Components\Select $component, $state, $record) {
                                if ($record && $record->exists) {
                                    $component->state($record->proceso_lineas()->pluck('idLineaProceso')->toArray());
                                }
                                else{
                                    $component->state([]);
                                }
                            })
                            ->searchable()
                            ->multiple()
                            ->preload(),
                        
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ClaveProcesos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('DescripcionProcesos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('IdTipoProcesosP')
                    ->label('Tipo de proceso')
                    ->formatStateUsing(fn ($state) => TipoProceso::find($state)->DescripcionTipoProcesos)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListProcesos::route('/'),
            'create' => Pages\CreateProceso::route('/create'),
            'edit' => Pages\EditProceso::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
