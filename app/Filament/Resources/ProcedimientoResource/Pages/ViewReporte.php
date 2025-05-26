<?php

namespace App\Filament\Resources\ProcedimientoResource\Pages;

use App\Filament\Resources\ProcedimientoResource;
use Filament\Resources\Pages\Page;

class ViewReporte extends Page
{
    protected static string $resource = ProcedimientoResource::class;

    protected static string $view = 'filament.resources.procedimiento-resource.pages.view-reporte';

    protected static ?string $navigationLabel = 'Vista previa';


    public function mount($record)
    {
        $this->record = $record;
    }
    
    
}
