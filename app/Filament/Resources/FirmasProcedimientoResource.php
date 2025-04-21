<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FirmasProcedimientoResource\Pages;
use App\Filament\Resources\FirmasProcedimientoResource\RelationManagers;
use App\Models\FirmasProcedimiento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FirmasProcedimientoResource extends Resource
{
    protected static ?string $model = FirmasProcedimiento::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationGroup = 'Gestión de calidad';

    protected static ?string $navigationLabel = 'Firmas de procedimientos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Tipo')
                    ->required()
                    ->maxLength(45),
                Forms\Components\TextInput::make('Idprocedimiento')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('Seccion')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('idUsuario')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Tipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Idprocedimiento')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('Seccion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('idUsuario')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListFirmasProcedimientos::route('/'),
            'create' => Pages\CreateFirmasProcedimiento::route('/create'),
            'edit' => Pages\EditFirmasProcedimiento::route('/{record}/edit'),
        ];
    }
}
