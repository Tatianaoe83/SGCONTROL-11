<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FirmasProcedimiento
 * 
 * @property int $Idfirma
 * @property string $Tipo
 * @property int $Idprocedimiento
 * @property string $Seccion
 * @property int $idUsuario
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class FirmasProcedimiento extends Model
{
	protected $table = 'firmas_procedimientos';
	protected $primaryKey = 'Idfirma';

	protected $casts = [
		'Idprocedimiento' => 'int',
		'idUsuario' => 'int'
	];

	protected $fillable = [
		'Tipo',
		'Idprocedimiento',
		'Seccion',
		'idUsuario'
	];
}
