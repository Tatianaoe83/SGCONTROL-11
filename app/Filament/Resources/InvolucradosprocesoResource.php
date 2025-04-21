<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvolucradosprocesoResource\Pages;
use App\Filament\Resources\InvolucradosprocesoResource\RelationManagers;
use App\Models\Involucradosproceso;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvolucradosprocesoResource extends Resource
{
    protected static ?string $model = Involucradosproceso::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Filament Shield';

    protected static ?string $navigationLabel = 'Involucrados al proceso';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('idProcedimientos')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('idPuesto')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('idProcedimientos')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('idPuesto')
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
            'index' => Pages\ListInvolucradosprocesos::route('/'),
            'create' => Pages\CreateInvolucradosproceso::route('/create'),
            'edit' => Pages\EditInvolucradosproceso::route('/{record}/edit'),
        ];
    }
}
