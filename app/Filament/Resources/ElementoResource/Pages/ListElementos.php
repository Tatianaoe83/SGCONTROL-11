<?php

namespace App\Filament\Resources\ElementoResource\Pages;

use App\Filament\Resources\ElementoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Tiposelemento; 
use Filament\Resources\Components\Tab; 

class ListElementos extends ListRecords
{
    protected static string $resource = ElementoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = ['all' => Tab::make('All')->badge($this->getModel()::count())];
 
        $tiers = Tiposelemento::orderBy('idtiposelementos', 'asc')
            ->withCount('elemento')
            ->get();
 
        foreach ($tiers as $tier) {
            $name = $tier->TiposElementos;
            $slug = str($name)->slug()->toString();
 
            $tabs[$slug] = Tab::make($name)
                ->modifyQueryUsing(function ($query) use ($tier) {
                    return $query->where('IdTipoElementoE', $tier->idtiposelementos);
                });
        }
 
        return $tabs;
    }

}
