<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Involucradosproceso
 * 
 * @property int $idInv
 * @property int $idProcedimientos
 * @property int $idPuesto
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Involucradosproceso extends Model
{
	protected $table = 'involucradosproceso';
	protected $primaryKey = 'idInv';

	protected $casts = [
		'idProcedimientos' => 'int',
		'idPuesto' => 'int'
	];

	protected $fillable = [
		'idProcedimientos',
		'idPuesto'
	];
}
