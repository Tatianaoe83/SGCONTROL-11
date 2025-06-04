<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlCambio extends Model
{
    use HasFactory;

    protected $table = 'control_cambios';

    protected $fillable = [
        'codigo',
        'nombre_documento',
        'tipo_documento',
        'proceso',
        'descripcion_cambio',
        'justificacion',
        'fecha',
        'elaboro',
        'reviso',
        'aprobo',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];
}
