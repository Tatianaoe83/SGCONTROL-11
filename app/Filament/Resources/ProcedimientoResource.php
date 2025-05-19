<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProcedimientoResource\Pages;
use App\Filament\Resources\ProcedimientoResource\RelationManagers;
use App\Models\Procedimiento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use App\Models\Note;
use App\Models\Proceso;
use App\Models\Estatus;
use App\Models\User;
use App\Models\Firmas;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Components\Tabs;


class ProcedimientoResource extends Resource
{
    protected static ?string $model = Procedimiento::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Gestión de calidad';

    protected static ?string $navigationLabel = 'Procedimientos';
   
    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        $notes = Note::where('section', 1)->orderBy('order')->get();
    
        return $form->schema([
            Tabs::make('Procedimiento')
                ->columnSpan('full')
                ->tabs([
                    Tabs\Tab::make('Información general')
                        ->schema([
                            Forms\Components\TextInput::make('NombreProcedimiento')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Select::make('IdProcesosP')
                                ->label('Proceso')
                                ->options(Proceso::all()->pluck('DescripcionProcesos', 'IdProcesos'))
                                ->required()
                                ->searchable(),
                            Forms\Components\TextInput::make('FolioProcedimientos')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('Version')
                                ->maxLength(255)
                                ->default(1),
                            Forms\Components\Select::make('Idestatus')
                                ->label('Estatus')
                                ->options(Estatus::all()->pluck('nombre', 'idestatus'))
                                ->required()
                                ->default(1)
                                ->searchable(),
                            Forms\Components\TextInput::make('Division')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('UnidadNegocio')
                                ->label('Unidad de negocio')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\DatePicker::make('fechaEmision')
                                ->label('Fecha de emision'),
                                
                        ]),
                    Tabs\Tab::make('Contenido del procedimiento')
                        ->schema([
                            Forms\Components\Repeater::make('blocks')
                                ->addable(false)
                                ->deletable(false)
                                ->reorderable(false)
                                ->label('Contenido del procedimiento')
                                ->default(fn ($get) => $get('blocks') ?? [])
                                ->schema(function () use ($notes) {
                                    return collect($notes)->map(function ($note) {
                                        return Forms\Components\Group::make([
                                            Forms\Components\Hidden::make("titulo_{$note->id}")->default($note->content),
                                            Forms\Components\Placeholder::make("header_{$note->id}")
                                                ->label('')
                                                ->content(fn () => $note->order . '.' . $note->content),
                                            TinyEditor::make("descripcion_{$note->id}")
                                                ->label('')
                                                ->required(),
                                        ]);
                                    })->toArray();
                                })
                                
                        ]),
                        Tabs\Tab::make('Firmas')
                        ->schema([

                            Forms\Components\Repeater::make('firmas')
                                ->schema([
                                Forms\Components\Select::make('idUsuario')
                                ->label('Usuario')
                                ->options(User::all()->pluck('name', 'id'))
                                ->searchable(),
                                Forms\Components\Select::make('IdFirmas')
                                ->label('Asignacion')
                                ->options(Firmas::all()->pluck('nombre', 'idfirmas'))
                                ->searchable(),
                                ])
                                ->reorderable(false)
                                ->addActionLabel('Agregar')
                                ->columns(2)
                          
                        ]),
                         Tabs\Tab::make('Control de cambios')
                        ->schema([
                          
                        ]),
                ]),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('NombreProcedimiento')
                ->searchable(),
                Tables\Columns\TextColumn::make('proceso.DescripcionProcesos')
                ->label('Proceso')
                ->numeric()
                ->sortable(),
                Tables\Columns\TextColumn::make('FolioProcedimientos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Version')
                    ->searchable(),
                Tables\Columns\TextColumn::make('estatusP.nombre')
                ->label('Estatus')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    
                    'Proceso' => 'gray',
                    'Liberado' => 'info',
                    'Revision' => 'warning',
                    'Firmas' => 'primary',
                    'Portal' => 'success',
                    'Detenido' => 'danger',
                    'Cerrado' => 'danger',
                })
                ->numeric()
                ->sortable(),
                Tables\Columns\TextColumn::make('FolioCambios')
                    ->label('Folio')
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
