<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IndicadoreResource\Pages;
use App\Filament\Resources\IndicadoreResource\RelationManagers;
use App\Models\Indicadore;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IndicadoreResource extends Resource
{
    protected static ?string $model = Indicadore::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    protected static ?string $navigationGroup = 'Gestión de calidad';

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('IdProcedimientoI')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('ClaveIndicador')
                    ->required()
                    ->maxLength(25),
                Forms\Components\TextInput::make('NombreIndicador')
                    ->required()
                    ->maxLength(1000),
                Forms\Components\TextInput::make('DescripcionIndicador')
                    ->required()
                    ->maxLength(1000),
                Forms\Components\TextInput::make('IdUnidadesI')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('IdPeriodosI')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('IdResponsable')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('IdEjecutor')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('VariableA')
                    ->maxLength(1000)
                    ->default(null),
                Forms\Components\TextInput::make('VariableB')
                    ->maxLength(1000)
                    ->default(null),
                Forms\Components\TextInput::make('Formula')
                    ->maxLength(50)
                    ->default(null),
                Forms\Components\TextInput::make('Rojo')
                    ->maxLength(50)
                    ->default(null),
                Forms\Components\TextInput::make('Amarillo')
                    ->maxLength(50)
                    ->default(null),
                Forms\Components\TextInput::make('Verde')
                    ->maxLength(50)
                    ->default(null),
                Forms\Components\TextInput::make('DocumentoIndicador')
                    ->maxLength(1)
                    ->default('x'),
                Forms\Components\TextInput::make('tipo')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('IdProcedimientoI')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ClaveIndicador')
                    ->searchable(),
                Tables\Columns\TextColumn::make('NombreIndicador')
                    ->searchable(),
                Tables\Columns\TextColumn::make('DescripcionIndicador')
                    ->searchable(),
                Tables\Columns\TextColumn::make('IdUnidadesI')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('IdPeriodosI')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('IdResponsable')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('IdEjecutor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('VariableA')
                    ->searchable(),
                Tables\Columns\TextColumn::make('VariableB')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Formula')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Rojo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Amarillo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Verde')
                    ->searchable(),
                Tables\Columns\TextColumn::make('DocumentoIndicador')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipo')
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
            'index' => Pages\ListIndicadores::route('/'),
            'create' => Pages\CreateIndicadore::route('/create'),
            'edit' => Pages\EditIndicadore::route('/{record}/edit'),
        ];
    }
}
