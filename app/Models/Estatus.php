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
class Estatus extends Model
{
	protected $table = 'estatus';
	protected $primaryKey = 'idestatus';

	protected $casts = [
		'idestatus' => 'int'
	];

	protected $fillable = [
		'nombre'
	];

	
	public function procedimiento()
	{
		return $this->belongsTo(Procedimiento::class, 'idestatus');
	}


}
