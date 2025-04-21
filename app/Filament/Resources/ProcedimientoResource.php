<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProcedimientoResource\Pages;
use App\Filament\Resources\ProcedimientoResource\RelationManagers;
use App\Models\Procedimiento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;


class ProcedimientoResource extends Resource
{
    protected static ?string $model = Procedimiento::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Gestión de calidad';

    protected static ?string $navigationLabel = 'Procedimientos';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('IdProcesosP')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('FolioProcedimientos')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('NombreProcedimiento')
                    ->required()
                    ->maxLength(255),
                TinyEditor::make('DocumentoEditable')
                    ->profile('default')
                    ->rtl()
                    ->columnSpan('full')
                    ->required(),
                Forms\Components\TextInput::make('Version')
                    ->maxLength(255)
                    ->default(1),
                Forms\Components\TextInput::make('Estatus')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('Division')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('FolioCambios')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('DescripcionCambios')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('IdProcesosP')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('FolioProcedimientos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('NombreProcedimiento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Version')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Estatus')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Division')
                    ->searchable(),
                Tables\Columns\TextColumn::make('FolioCambios')
                    ->searchable(),
                Tables\Columns\TextColumn::make('DescripcionCambios')
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListProcedimientos::route('/'),
            'create' => Pages\CreateProcedimiento::route('/create'),
            'view' => Pages\ViewProcedimiento::route('/{record}'),
            'edit' => Pages\EditProcedimiento::route('/{record}/edit'),
        ];
    }
}
