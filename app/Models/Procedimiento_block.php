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
class Procedimiento_block extends Model
{
	protected $table = 'procedimientos_block';
	protected $primaryKey = 'idprocedimientos_block';

	protected $casts = [
		'idprocedimientos_block' => 'int'
	];

	protected $fillable = [
		'procedimiento_id',
		'titulo',
		'descripcion'
	];

	public function procedimiento()
	{
		return $this->belongsTo(Procedimiento::class);
	}

}
