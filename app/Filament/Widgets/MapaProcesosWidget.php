<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MapaProcesosWidget extends Widget
{
    protected static string $view = 'filament.widgets.mapa-procesos-widget';
    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        try {
            // Verificar si las tablas existen
            $procesosCount = DB::table('procesos')->count();
            $tipoprocesosCount = DB::table('tipoprocesos')->count();
            
            Log::info("MapaProcesosWidget: Tabla procesos tiene {$procesosCount} registros");
            Log::info("MapaProcesosWidget: Tabla tipoprocesos tiene {$tipoprocesosCount} registros");

            if ($procesosCount === 0) {
                return [
                    'nodes' => [],
                    'links' => [],
                    'error' => 'No hay procesos registrados en la base de datos'
                ];
            }

            $procesos = DB::table('procesos')
                ->join('tipoprocesos', 'tipoprocesos.IdTipoProcesos', '=', 'procesos.IdTipoProcesosP')
                ->select(
                    'procesos.IdProcesos as id',
                    'procesos.ClaveProcesos as clave',
                    'procesos.DescripcionProcesos as descripcion',
                    'tipoprocesos.NivelTipoProcesos as nivel',
                    'tipoprocesos.ClaveTipoProcesos as tipo'
                )
                ->whereNull('procesos.deleted_at')
                ->get();

            Log::info("MapaProcesosWidget: Consulta ejecutada, {$procesos->count()} procesos encontrados");

            $nodes = $procesos->map(fn ($p) => [
                'key' => $p->id,
                'text' => $p->clave . "\n" . $p->descripcion,
                'fill' => match($p->tipo) {
                    'PE' => '#FFE599',
                    'PC' => '#9FC5E8',
                    'IND' => '#B6D7A8',
                    'PAA', 'POA' => '#F3F3F3',
                    default => '#D9D2E9'
                },
                'nivel' => $p->nivel,
            ]);

            // Si hay relaciones, se pueden definir aquí (manual o desde otra tabla)
            $links = []; // agregar lógica según conexiones

            return [
                'nodes' => $nodes,
                'links' => $links,
                'debug' => [
                    'procesos_count' => $procesosCount,
                    'tipoprocesos_count' => $tipoprocesosCount,
                    'nodes_count' => $nodes->count()
                ]
            ];

        } catch (\Exception $e) {
            Log::error("MapaProcesosWidget Error: " . $e->getMessage());
            Log::error("MapaProcesosWidget Stack: " . $e->getTraceAsString());
            
            return [
                'nodes' => [],
                'links' => [],
                'error' => 'Error al cargar los datos: ' . $e->getMessage()
            ];
        }
    }
}
