<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $connection = 'db_rh';
    protected $table = 'cidade';

    protected $fillable = [
        'nome',
        'codigo',
        'estado_id',
    ];
}
