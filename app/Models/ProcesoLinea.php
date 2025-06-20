<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProcesoLinea extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'proceso_linea';
    protected $primaryKey = 'idProcesoLinea';

    protected $fillable = [
        'idProceso',
        'idLineaProceso',
    ];

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'idProceso');
    }

    public function lineaProceso()
    {
        return $this->belongsTo(LineaProceso::class, 'idLineaProceso');
    }


}
