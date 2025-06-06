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
class Politica_block extends Model
{
	protected $table = 'politicas_block';
	protected $primaryKey = 'idpoliticas_block';

	protected $casts = [
		'idpoliticas_block' => 'int'
	];

	protected $fillable = [
		'politica_id',
		'titulo',
		'descripcion'
	];

	public function politica()
	{
		return $this->belongsTo(Politica::class, 'politica_id');
	}

}
