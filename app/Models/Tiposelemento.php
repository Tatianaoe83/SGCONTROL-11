<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tiposelemento
 * 
 * @property int $idtiposelementos
 * @property string $TiposElementos
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Tiposelemento extends Model
{
	protected $table = 'tiposelementos';
	protected $primaryKey = 'idtiposelementos';

	protected $fillable = [
		'TiposElementos'
	];

	public function elemento()
	{
		return $this->hasMany(Elemento::class, 'IdTipoElementoE');
	}

}
