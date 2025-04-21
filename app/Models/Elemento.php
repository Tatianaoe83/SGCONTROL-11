<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Elemento
 * 
 * @property int $IdElementos
 * @property int $IdTipoElementoE
 * @property string $Control
 * @property int $IdProcedimiento
 * @property string $CodigoElemento
 * @property string $DescripcionElemento
 * @property int $IdPuestoEjecutor
 * @property int $IdPuestoResguardo
 * @property string $IdMedioSoporteE
 * @property string $IdUbicacionE
 * @property float $VersionElemento
 * @property Carbon $FechaVersionElemento
 * @property string $CodigoFormato
 * @property string $Formato
 * @property float $VersionFormato
 * @property Carbon $FechaVersionFormato
 * @property string $documentoReferencia
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Elemento extends Model
{
	protected $table = 'elementos';
	protected $primaryKey = 'IdElementos';

	protected $casts = [
		'IdTipoElementoE' => 'int',
		'IdProcedimiento' => 'int',
		'IdPuestoEjecutor' => 'int',
		'IdPuestoResguardo' => 'int',
		'VersionElemento' => 'float',
		'FechaVersionElemento' => 'datetime',
		'VersionFormato' => 'float',
		'FechaVersionFormato' => 'datetime'
	];

	protected $fillable = [
		'IdTipoElementoE',
		'Control',
		'IdProcedimiento',
		'CodigoElemento',
		'DescripcionElemento',
		'IdPuestoEjecutor',
		'IdPuestoResguardo',
		'IdMedioSoporteE',
		'IdUbicacionE',
		'VersionElemento',
		'FechaVersionElemento',
		'CodigoFormato',
		'Formato',
		'VersionFormato',
		'FechaVersionFormato',
		'documentoReferencia'
	];

	public function tiposelemento()
	{
		return $this->belongsTo(Tiposelemento::class, 'IdTipoElementoE');
	}
}
