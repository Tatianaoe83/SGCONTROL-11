<?php

namespace App\Filament\Resources\ProcedimientoResource\Pages;

use App\Filament\Resources\ProcedimientoResource;
use Filament\Resources\Pages\Page;
use Filament\Actions\Action;
use App\Models\Procedimiento;

class ViewReporte extends Page
{
    protected static string $resource = ProcedimientoResource::class;

    protected static string $view = 'filament.resources.procedimiento-resource.pages.view-reporte';

    protected static ?string $title = 'Reporte del Procedimiento';

    public $procedimiento;

    public function mount($record)
    {
        //\Log::info($record);
        $this->procedimiento = Procedimiento::with(['proceso', 'estatusP', 'procedimiento_firmas.user', 'procedimiento_firmas.firma', 'blocks'])->find($record);
     
    }

   
}
