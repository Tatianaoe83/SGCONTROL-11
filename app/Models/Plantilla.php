<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Periodo
 * 
 * @property int $IdPlantilla
 * @property string $Tipo
 * @property string $DescripcionProcesos
 * @property string $DocumentoEditable
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class Plantilla extends Model
{
	use SoftDeletes;
	
	protected $table = 'plantillas';
	protected $primaryKey = 'IdPlantilla';

	protected $fillable = [
		'Tipo',
		'DescripcionProcesos',
		'DocumentoEditable'
	];
}
