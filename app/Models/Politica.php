<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Politica
 *
 * @package App\Models
 */
class Politica extends Model
{
	protected $table = 'politicas';
	protected $primaryKey = 'Idpoliticas';

	protected $casts = [
		'Idpoliticas' => 'int'
		
	];

	protected $fillable = [
		'Nombrepolitica',
		'NombreArea',
		'Foliopoliticas',
		'Version',
		'Idestatus',
		'Division',
		'UnidadNegocio',
		'fechaEmision',
		'FolioCambios',
		'DescripcionCambios'
	];

	public function blocksPolitica()
	{
		return $this->hasMany(Politica_block::class, 'politica_id');
	}

	public function estatusPolitica()
    {
        return $this->hasMany(\App\Models\Estatus::class, 'idestatus');
    }

	public function politica_firmas()
    {
        return $this->hasMany(\App\Models\Politica_firmas::class, 'Idpoliticas', 'Idpoliticas');
    }

}
