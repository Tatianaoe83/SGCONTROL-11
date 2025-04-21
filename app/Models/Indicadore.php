<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Indicadore
 * 
 * @property int $IdIndicadores
 * @property int|null $IdProcedimientoI
 * @property string $ClaveIndicador
 * @property string $NombreIndicador
 * @property string $DescripcionIndicador
 * @property int|null $IdUnidadesI
 * @property int|null $IdPeriodosI
 * @property int $IdResponsable
 * @property int $IdEjecutor
 * @property string|null $VariableA
 * @property string|null $VariableB
 * @property string|null $Formula
 * @property string|null $Rojo
 * @property string|null $Amarillo
 * @property string|null $Verde
 * @property string|null $DocumentoIndicador
 * @property string $tipo
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Indicadore extends Model
{
	protected $table = 'indicadores';
	protected $primaryKey = 'IdIndicadores';

	protected $casts = [
		'IdProcedimientoI' => 'int',
		'IdUnidadesI' => 'int',
		'IdPeriodosI' => 'int',
		'IdResponsable' => 'int',
		'IdEjecutor' => 'int'
	];

	protected $fillable = [
		'IdProcedimientoI',
		'ClaveIndicador',
		'NombreIndicador',
		'DescripcionIndicador',
		'IdUnidadesI',
		'IdPeriodosI',
		'IdResponsable',
		'IdEjecutor',
		'VariableA',
		'VariableB',
		'Formula',
		'Rojo',
		'Amarillo',
		'Verde',
		'DocumentoIndicador',
		'tipo'
	];
}
