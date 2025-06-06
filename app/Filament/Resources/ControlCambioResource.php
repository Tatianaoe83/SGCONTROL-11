<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ControlCambioResource\Pages;
use App\Models\ControlCambio;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ControlCambioResource extends Resource
{
    protected static ?string $model = ControlCambio::class;

    protected static ?string $navigationIcon = 'heroicon-m-chart-bar';

    protected static ?string $navigationLabel = 'Control de Cambios';

    protected static ?string $navigationGroup = 'Gestión de calidad';

    protected static ?int $navigationSort = 4;



    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('codigo')->label('Código')->required(),
            Forms\Components\TextInput::make('nombre_documento')->label('Nombre del documento')->required(),
            Forms\Components\TextInput::make('tipo_documento')->label('Tipo de documento')->required(),
            Forms\Components\TextInput::make('proceso')->required(),
            Forms\Components\TextInput::make('descripcion_cambio')->label('Descripción del cambio')->required(),
            Forms\Components\TextInput::make('justificacion')->required(),
            Forms\Components\DatePicker::make('fecha')->required(),
            Forms\Components\TextInput::make('elaboro')->required(),
            Forms\Components\TextInput::make('reviso')->required(),
            Forms\Components\TextInput::make('aprobo')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('codigo')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('nombre_documento')->label('Nombre del documento')->limit(50),
            Tables\Columns\TextColumn::make('tipo_documento')->label('Tipo')->searchable(),
            Tables\Columns\TextColumn::make('proceso')->searchable(),
            Tables\Columns\TextColumn::make('descripcion_cambio')->label('Cambio')->limit(50),
            Tables\Columns\TextColumn::make('justificacion')->limit(50),
            Tables\Columns\TextColumn::make('fecha')->date(),
            Tables\Columns\TextColumn::make('elaboro')->limit(30),
            Tables\Columns\TextColumn::make('reviso')->limit(30),
            Tables\Columns\TextColumn::make('aprobo')->limit(30),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->defaultSort('fecha', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListControlCambios::route('/'),
            'create' => Pages\CreateControlCambio::route('/create'),
            'edit' => Pages\EditControlCambio::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Control de Cambio';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Controles de Cambio';
    }
}
