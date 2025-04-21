<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PuestoResource\Pages;
use App\Filament\Resources\PuestoResource\RelationManagers;
use App\Models\Puesto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PuestoResource extends Resource
{
    protected static ?string $model = Puesto::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationGroup = 'Organización';

    protected static ?string $navigationLabel = 'Puestos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ClavePuesto')
                    ->required()
                    ->maxLength(13),
                Forms\Components\TextInput::make('DescripcionPuesto')
                    ->required()
                    ->maxLength(150),
                Forms\Components\TextInput::make('IdTiposDePuestoP')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('ImagenPuesto')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('perfilPuesto')
                    ->required()
                    ->maxLength(499),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ClavePuesto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('DescripcionPuesto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('IdTiposDePuestoP')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ImagenPuesto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('perfilPuesto')
                    ->searchable(),
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
            'index' => Pages\ListPuestos::route('/'),
            'create' => Pages\CreatePuesto::route('/create'),
            'edit' => Pages\EditPuesto::route('/{record}/edit'),
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
