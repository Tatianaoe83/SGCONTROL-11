<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ThreeScene extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass-circle';
    protected static ?string $navigationGroup = 'Asistencia';
    protected static string $view = 'filament.pages.three-scene.index';
    protected static ?string $navigationLabel = 'Asistente virtual';
    
}
