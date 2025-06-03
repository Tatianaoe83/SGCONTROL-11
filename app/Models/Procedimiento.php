<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Procedimiento
 * 
 * @property int $Idprocedimientos
 * @property int $IdProcesosP
 * @property string $FolioProcedimientos
 * @property string $NombreProcedimiento
 * @property string|null $DocumentoEditable
 * @property string|null $Version
 * @property int $Idestatus
 * @property string $Division
 * @property string $FolioCambios
 * @property string $DescripcionCambios
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Procedimiento extends Model
{
	protected $table = 'procedimientos';
	protected $primaryKey = 'Idprocedimientos';

	protected $casts = [
		'IdProcesosP' => 'int'
		
	];

	protected $fillable = [
		
		'NombreProcedimiento',
		'IdProcesosP',
		'FolioProcedimientos',
		'Version',
		'Idestatus',
		'Division',
		'UnidadNegocio',
		'fechaEmision'
	];

	public function blocks()
	{
		return $this->hasMany(Procedimiento_block::class, 'procedimiento_id');
	}

	public function estatusP()
    {
        return $this->hasMany(\App\Models\Estatus::class, 'idestatus');
    }

	public function proceso()
    {
        return $this->hasMany(\App\Models\Proceso::class, 'IdProcesos');
    }

	public function procedimiento_firmas()
    {
        return $this->hasMany(\App\Models\Procedimiento_firmas::class, 'Idprocedimientos', 'Idprocedimientos');
    }

}
