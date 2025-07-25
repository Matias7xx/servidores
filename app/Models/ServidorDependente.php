<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServidorDependente extends Model
{
    use HasFactory;
    protected $connection = 'db_rh';
    protected $table = 'servidor_dependentes';

    protected $fillable = [
        'servidor_matricula',
        'tipo_dependente',
        'nome',
        'cpf',
        'sexo_dependente',
        'data_nascimento',
        'documento',
        'historico',
        'status',
        'created_at',
        'updated_at'
    ];
}
