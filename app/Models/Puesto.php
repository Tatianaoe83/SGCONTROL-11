<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Puesto
 * 
 * @property int $IdPuestos
 * @property string $ClavePuesto
 * @property string $DescripcionPuesto
 * @property int $IdTiposDePuestoP
 * @property string|null $ImagenPuesto
 * @property string $perfilPuesto
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string|null $deleted_at
 * 
 * @property Tiposdepuesto $tiposdepuesto
 *
 * @package App\Models
 */
class Puesto extends Model
{
	use SoftDeletes;
	protected $table = 'puestos';
	protected $primaryKey = 'IdPuestos';

	protected $casts = [
		'IdTiposDePuestoP' => 'int'
	];

	protected $fillable = [
		'ClavePuesto',
		'DescripcionPuesto',
		'IdTiposDePuestoP',
		'ImagenPuesto',
		'perfilPuesto'
	];

	public function tiposdepuesto()
	{
		return $this->belongsTo(Tiposdepuesto::class, 'IdTiposDePuestoP');
	}
}
