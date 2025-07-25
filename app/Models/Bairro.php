<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bairro extends Model
{
    protected $fillable = [
        'id',
        'nome',
        'cidade_id',
        'unidade_id',
        'status',
    ];
}
