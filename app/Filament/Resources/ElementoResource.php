<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ElementoResource\Pages;
use App\Filament\Resources\ElementoResource\RelationManagers;
use App\Models\Elemento;
use App\Models\Tiposelemento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;

class ElementoResource extends Resource
{
    protected static ?string $model = Elemento::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Gestión de calidad';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               
                Forms\Components\Select::make('IdTipoElementoE')
                    ->label('Tipo Elemento')
                    ->options(Tiposelemento::all()->pluck('TiposElementos', 'idtiposelementos'))
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('Control')
                    ->required()
                    ->maxLength(11),
                Forms\Components\TextInput::make('IdProcedimiento')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('CodigoElemento')
                    ->required()
                    ->maxLength(15),
                Forms\Components\TextInput::make('DescripcionElemento')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('IdPuestoEjecutor')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('IdPuestoResguardo')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('IdMedioSoporteE')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('IdUbicacionE')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('VersionElemento')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('FechaVersionElemento')
                    ->required(),
                Forms\Components\TextInput::make('CodigoFormato')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('Formato')
                    ->required()
                    ->maxLength(11),
                Forms\Components\TextInput::make('VersionFormato')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('FechaVersionFormato')
                    ->required(),
                Forms\Components\TextInput::make('documentoReferencia')
                    ->required()
                    ->maxLength(455),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tiposelemento.TiposElementos')
                    ->label('Tipo Elemento')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('Control')
                    ->searchable(),
                Tables\Columns\TextColumn::make('IdProcedimiento')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('CodigoElemento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('DescripcionElemento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('IdPuestoEjecutor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('IdPuestoResguardo')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('IdMedioSoporteE')
                    ->searchable(),
                Tables\Columns\TextColumn::make('IdUbicacionE')
                    ->searchable(),
                Tables\Columns\TextColumn::make('VersionElemento')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('FechaVersionElemento')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('CodigoFormato')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Formato')
                    ->searchable(),
                Tables\Columns\TextColumn::make('VersionFormato')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('FechaVersionFormato')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('documentoReferencia')
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
            'index' => Pages\ListElementos::route('/'),
            'create' => Pages\CreateElemento::route('/create'),
            'edit' => Pages\EditElemento::route('/{record}/edit'),
        ];
    }
}
