<?php

namespace App\Filament\Resources\PoliticaResource\Pages;

use App\Filament\Resources\PoliticaResource;
use Filament\Resources\Pages\Page;
use Filament\Actions\Action;
use App\Models\Politica;

class ViewReportePolitica extends Page
{
    protected static string $resource = PoliticaResource::class;

    protected static string $view = 'filament.resources.politica-resource.pages.view-reporte';

    protected static ?string $title = 'Reporte de la Política';

    public $politica;

    public function mount($record)
    {
        //\Log::info($record);
        $this->politica = Politica::with(['estatusPolitica', 'politica_firmas.user', 'politica_firmas.firma', 'blocksPolitica'])->find($record);
     
    }

   
}
