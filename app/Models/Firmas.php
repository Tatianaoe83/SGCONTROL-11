<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Estatus
 * 
 * @property int $idestatus
 * @property string $nombre
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Firmas extends Model
{
	protected $table = 'firmas';
	protected $primaryKey = 'idfirmas';

	protected $casts = [
		'idfirmas' => 'int'
	];

	protected $fillable = [
		'nombre'
	];


}
