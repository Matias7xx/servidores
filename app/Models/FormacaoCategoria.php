<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormacaoCategoria extends Model
{
    use HasFactory;
    protected $connection = 'db_rh';
    protected $table = 'formacao_categoria';

    protected $fillable = [
        'nome',
        'status'
    ];
}
