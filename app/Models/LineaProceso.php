<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LineaProceso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lineaproceso';
    protected $primaryKey = 'idLineaProceso';

    protected $fillable = [
        'nombreLineaProceso',
        'responsableProceso',
    ];

    public function procesoLinea()
    {
        return $this->hasMany(ProcesoLinea::class, 'idLineaProceso');
    }


}
