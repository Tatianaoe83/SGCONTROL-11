<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlCambio extends Model
{
    use HasFactory;

    protected $table = 'control_cambios';
    protected $primaryKey = 'idCambio';

    protected $fillable = [
        'folioCambio',
        'abrevCambio',
        'anioCambio',
        'consecutivoCambio',
        'sumaActual',
        'naturaleza',
        'descripcionNaturaleza',
        'afectacion',
        'redCambio',
        'tElemento',
        'tProceso',
        'folioElemento',
        'nomElemento',
        'procElemento',
        'procedPertenece',
        'lineAccion',
        'responsableelemento',
        'Estatus',
        'detalleestatus',
        'seguimiento',
        'prioridad',
        'historial',
    ];

    protected $casts = [
        'anioCambio' => 'int',
        'consecutivoCambio' => 'int',
        'sumaActual' => 'int',
        'Estatus' => 'string',
        'descripcionNaturaleza' => 'text',
        'redCambio' => 'text',
        'detalleestatus' => 'text',
        'seguimiento' => 'text',
        'historial' => 'text',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}
