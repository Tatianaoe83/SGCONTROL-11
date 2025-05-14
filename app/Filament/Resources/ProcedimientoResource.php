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
        $notes = Note::where('section', 1)->orderBy('order')->get();

        return $form->schema([
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
            Forms\Components\Repeater::make('blocks')
                ->addable(false)
                ->deletable(false)
                ->reorderable(false)
                ->label('Contenido del procedimiento')
                ->schema(function () use ($notes) {
                    return collect($notes)->map(function ($note) {

                        return Forms\Components\Group::make([
                            Forms\Components\Hidden::make('titulo')->default($note->content),
                            Forms\Components\Placeholder::make("header_{$note->id}")
                                ->label('')
                                ->content(fn () => $note->order.'.'.$note->content),
                            TinyEditor::make("descripcion")
                                ->label('')
                                ->required(),
                        ]);
                    })->toArray();
                }),
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
                Tables\Columns\TextColumn::make('Division')
                    ->searchable(),
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

    protected function mutateFormDataBeforeCreate(array $data): array
        {
            logger()->error('mutateFormDataBeforeCreate Error: ' . $data['blocks']);
                $blocks = $data['blocks'];
                unset($data['blocks']);
                $this->creatingProcedureBlocks = $blocks;
                return $data;
        }

        protected function afterCreate(): void
        {
            logger()->error('afterCreate Error: ');

            foreach ($this->creatingProcedureBlocks as $block) {
                $this->record->blocks()->create([
                    'titulo' => $block['titulo'],
                    'descripcion' => $block['descripcion'],
                ]);
            }
        }

}
