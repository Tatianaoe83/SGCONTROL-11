<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Periodo
 * 
 * @property int $IdPeriodos
 * @property string $DescripcionPeriodo
 * @property int|null $NumDias
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Periodo extends Model
{
	protected $table = 'periodos';
	protected $primaryKey = 'IdPeriodos';

	protected $casts = [
		'NumDias' => 'int'
	];

	protected $fillable = [
		'DescripcionPeriodo',
		'NumDias'
	];
}
