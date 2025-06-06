<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes; 

    protected $table = 'notes';
	protected $primaryKey = 'idNote';

    protected $fillable = [
        'order',
        'content',
        'section',
    ];

}
