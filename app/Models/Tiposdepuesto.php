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
 * Class Tiposdepuesto
 * 
 * @property int $IdTiposDePuesto
 * @property string|null $TiposDePuesto
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Puesto[] $puestos
 *
 * @package App\Models
 */
class Tiposdepuesto extends Model
{
	use SoftDeletes;
	protected $table = 'tiposdepuesto';
	protected $primaryKey = 'IdTiposDePuesto';

	protected $fillable = [
		'TiposDePuesto'
	];

	public function puestos()
	{
		return $this->hasMany(Puesto::class, 'IdTiposDePuestoP');
	}
}
