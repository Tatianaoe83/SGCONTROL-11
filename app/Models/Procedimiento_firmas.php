<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Procedimiento_block
 * 
 * @property int $procedimiento_id
 * @property string $titulo
 * @property string $descripcion
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Procedimiento_firmas extends Model
{
	protected $table = 'procedimientos_firmas';
	protected $primaryKey = 'Idprocedimientos_firmas';

	protected $casts = [
		'Idprocedimientos_firmas' => 'int'
	];

	protected $fillable = [
		'IdFirmas',
		'Idprocedimientos',
		'idUsuario'
	];

	public function procedimiento()
	{
		return $this->belongsTo(Procedimiento::class, 'Idprocedimientos_firmas');
	}

}
