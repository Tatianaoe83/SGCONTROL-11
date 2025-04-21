<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Procedimiento
 * 
 * @property int $Idprocedimientos
 * @property int $IdProcesosP
 * @property string $FolioProcedimientos
 * @property string $NombreProcedimiento
 * @property string|null $DocumentoEditable
 * @property string|null $Version
 * @property string|null $Estatus
 * @property string $Division
 * @property string $FolioCambios
 * @property string $DescripcionCambios
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Procedimiento extends Model
{
	protected $table = 'procedimientos';
	protected $primaryKey = 'Idprocedimientos';

	protected $casts = [
		'IdProcesosP' => 'int'
	];

	protected $fillable = [
		'IdProcesosP',
		'FolioProcedimientos',
		'NombreProcedimiento',
		'DocumentoEditable',
		'Version',
		'Estatus',
		'Division',
		'FolioCambios',
		'DescripcionCambios'
	];
}
