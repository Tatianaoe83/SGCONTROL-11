<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IndicadoresregistroResource\Pages;
use App\Filament\Resources\IndicadoresregistroResource\RelationManagers;
use App\Models\Indicadoresregistro;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IndicadoresregistroResource extends Resource
{
    protected static ?string $model = Indicadoresregistro::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';


    protected static ?string $navigationGroup = 'Gestión de calidad';

    protected static ?string $navigationLabel = 'Resultados de indicadores';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('usuario')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('idRegistroIndi')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('variableA')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('variableB')
                    ->numeric()
                    ->default(null),
                Forms\Components\DatePicker::make('fechaA'),
                Forms\Components\DatePicker::make('fechaB'),
                Forms\Components\Textarea::make('comentarios')
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('fecha')
                    ->required(),
                Forms\Components\TextInput::make('resultado')
                    ->required()
                    ->maxLength(10),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('idRegistroIndi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('variableA')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('variableB')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fechaA')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fechaB')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('resultado')
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
            'index' => Pages\ListIndicadoresregistros::route('/'),
            'create' => Pages\CreateIndicadoresregistro::route('/create'),
            'edit' => Pages\EditIndicadoresregistro::route('/{record}/edit'),
        ];
    }
}
