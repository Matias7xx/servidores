<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FormacaoCurso;

class ServidorFormacao extends Model
{
    use HasFactory;
    protected $connection = 'db_rh';
    protected $table = 'servidor_graduacao';
    protected $fillable = [
    'servidor_id',
    'servidor_matricula',
    'curso_id',
    'data_conclusao',
    'obs',
    'anexo_frente',
    'anexo_verso',
    'validacao_status',
    'historico',
    'status'
];

    public function formacaoServidorCurso()
    {
        return $this->belongsTo(FormacaoCurso::class, 'curso_id', 'id');
    }
}
