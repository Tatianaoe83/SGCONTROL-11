<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Indicadoresregistro
 * 
 * @property int $idRegistro
 * @property string $usuario
 * @property int $idRegistroIndi
 * @property int|null $variableA
 * @property int|null $variableB
 * @property Carbon|null $fechaA
 * @property Carbon|null $fechaB
 * @property string|null $comentarios
 * @property Carbon $fecha
 * @property string $resultado
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Indicadoresregistro extends Model
{
	protected $table = 'indicadoresregistro';
	protected $primaryKey = 'idRegistro';

	protected $casts = [
		'idRegistroIndi' => 'int',
		'variableA' => 'int',
		'variableB' => 'int',
		'fechaA' => 'datetime',
		'fechaB' => 'datetime',
		'fecha' => 'datetime'
	];

	protected $fillable = [
		'usuario',
		'idRegistroIndi',
		'variableA',
		'variableB',
		'fechaA',
		'fechaB',
		'comentarios',
		'fecha',
		'resultado'
	];
}
