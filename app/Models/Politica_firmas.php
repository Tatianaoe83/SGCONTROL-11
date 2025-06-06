<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Politica_firmas
 * 
 * @property int $politica_id
 * @property string $titulo
 * @property string $descripcion
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Politica_firmas extends Model
{
	protected $table = 'politicas_firmas';
	protected $primaryKey = 'Idpoliticas_firmas';

	protected $casts = [
		'Idpoliticas_firmas' => 'int'
	];

	protected $fillable = [
		'IdFirmas',
		'Idpoliticas',
		'idUsuario'
	];

	public function politica()
	{
		return $this->belongsTo(Politica::class, 'Idpoliticas_firmas');
	}

	public function firma()
	{
		return $this->belongsTo(Firmas::class, 'IdFirmas');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'idUsuario');
	}
}
