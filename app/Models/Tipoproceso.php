<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Tipoproceso
 * 
 * @property int $IdTipoProcesos
 * @property string $ClaveTipoProcesos
 * @property string $DescripcionTipoProcesos
 * @property int|null $NivelTipoProcesos
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Proceso[] $procesos
 *
 * @package App\Models
 */
class Tipoproceso extends Model
{
	use SoftDeletes;
	protected $table = 'tipoprocesos';
	protected $primaryKey = 'IdTipoProcesos';

	protected $casts = [
		'NivelTipoProcesos' => 'int'
	];

	protected $fillable = [
		'ClaveTipoProcesos',
		'DescripcionTipoProcesos',
		'NivelTipoProcesos'
	];

	public function procesos()
	{
		return $this->hasMany(Proceso::class, 'IdTipoProcesosP');
	}
}
