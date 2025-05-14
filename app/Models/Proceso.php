<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Proceso
 * 
 * @property int $IdProcesos
 * @property string $ClaveProcesos
 * @property string $DescripcionProcesos
 * @property int $IdTipoProcesosP
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string|null $deleted_at
 * 
 * @property Tipoproceso $tipoproceso
 *
 * @package App\Models
 */
class Proceso extends Model
{
	use SoftDeletes;
	protected $table = 'procesos';
	protected $primaryKey = 'IdProcesos';

	protected $casts = [
		'IdTipoProcesosP' => 'int'
	];

	protected $fillable = [
		'ClaveProcesos',
		'DescripcionProcesos',
		'IdTipoProcesosP'
	];

	public function tipoproceso()
	{
		return $this->belongsTo(Tipoproceso::class, 'IdTipoProcesosP');
	}

	
	public function procedimiento()
	{
		return $this->belongsTo(Procedimiento::class, 'IdProcesos');
	}

}
