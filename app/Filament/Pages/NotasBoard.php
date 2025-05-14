<?php

namespace App\Filament\Pages;


use Filament\Pages\Page;

class NotasBoard extends Page
{
    protected static ?string $title = 'Plantillas generales';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.notas-board';

    protected static ?string $navigationGroup = 'Gestión de calidad';

    protected static ?string $navigationLabel = 'Plantillas generales';

    protected static ?int $navigationSort = 1;

   

}
