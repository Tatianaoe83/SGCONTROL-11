<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlantillaResource\Pages;
use App\Filament\Resources\PlantillaResource\RelationManagers;
use App\Models\Plantilla;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Components\Toggle;


class PlantillaResource extends Resource
{
    protected static ?string $model = Plantilla::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $navigationGroup = 'Gestión de calidad';

    protected static ?string $navigationLabel = 'Plantillas generales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Tipo')
                    ->required()
                    ->maxLength(7),
                Forms\Components\TextInput::make('DescripcionProcesos')
                    ->required()
                    ->maxLength(50),
                Forms\Components\Textarea::make('DocumentoEditable')
                    ->columnSpanFull(),

            TinyEditor::make('DocumentoEditable')
                ->label('Contenido HTML')
                ->profile('default')
                ->columnSpanFull()
                ->required(),

            // Opcional: vista previa
            Toggle::make('mostrar_preview')
                ->label('Mostrar vista previa')
                ->default(true)
                ->reactive(),
                
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Tipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('DescripcionProcesos')
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
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPlantillas::route('/'),
            'create' => Pages\CreatePlantilla::route('/create'),
            'edit' => Pages\EditPlantilla::route('/{record}/edit'),
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
