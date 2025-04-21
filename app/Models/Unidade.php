<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Unidade
 * 
 * @property int $IdUnidades
 * @property string $DescripcionUnidades
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Unidade extends Model
{
	protected $table = 'unidades';
	protected $primaryKey = 'IdUnidades';

	protected $fillable = [
		'DescripcionUnidades'
	];
}
