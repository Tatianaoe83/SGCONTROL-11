<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ElementoResource\Pages;
use App\Filament\Resources\ElementoResource\RelationManagers;
use App\Models\Elemento;
use App\Models\Tiposelemento;
use App\Models\Procedimiento;
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
                    ->default('Interno')
                    ->maxLength(11),
                Forms\Components\Select::make('IdProcedimiento')
                    ->label('Procedimiento')
                    ->options(Procedimiento::all()->pluck('NombreProcedimiento', 'Idprocedimientos'))
                    ->searchable(),
                Forms\Components\TextInput::make('CodigoElemento')
                    ->label('Código Elemento')
                    ->maxLength(15),
                Forms\Components\TextInput::make('DescripcionElemento')
                    ->label('Descripción Elemento')
                    ->maxLength(255),
                Forms\Components\TextInput::make('IdPuestoEjecutor')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('IdPuestoResguardo')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('IdMedioSoporteE')
                    ->label('Medio Soporte')
                    ->options([
                        'N/A' => 'N/A',
                        'Físico' => 'Físico',
                        'Digital' => 'Digital',
                        'Híbrido' => 'Híbrido',
                    ])
                    ->required()
                    ->searchable(),
                Forms\Components\Textarea::make('IdUbicacionE')
                    ->label('Ubicación')
                    ->rows(4)
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('VersionElemento')
                    ->label('Versión Elemento')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('FechaVersionElemento')
                    ->label('Fecha Versión Elemento')
                    ->required(),
                Forms\Components\TextInput::make('CodigoFormato')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('Formato')
                    ->required()
                    ->maxLength(11),
                Forms\Components\TextInput::make('VersionFormato')
                    ->label('Versión Formato')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('FechaVersionFormato')
                    ->label('Fecha Versión Formato')
                    ->required(),
                Forms\Components\FileUpload::make('documentoReferencia')
                    ->label('Documento Referencia')
                    ->directory('documentos')
                    ->preserveFilenames()
                    ->storeFileNamesIn('attachment_file_names'),
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
                Tables\Columns\TextColumn::make('procedimiento.NombreProcedimiento')
                    ->label('Procedimiento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('DescripcionElemento')
                    ->label('Descripción Elemento')
                    ->wrap()
                ->searchable(),
                Tables\Columns\TextColumn::make('IdPuestoEjecutor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('IdPuestoResguardo')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('IdMedioSoporteE')
                    ->label('Medio Soporte')
                    ->searchable()
             
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
