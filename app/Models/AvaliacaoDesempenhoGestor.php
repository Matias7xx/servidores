<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvaliacaoDesempenhoGestor extends Model
{
    use HasFactory;
    protected $connection = 'db_rh';
    protected $table = 'avaliacao_desempenho_gestor';

    protected $fillable = [
        'id_usuario_cadastro',
        'data_hora_cadastro',
        'id_delegacia',
        'mes',
        'ano',
        'c1',
        'c2',
        'c3',
        'c4',
        'c5',
        'total',
        'id_servidor',
        'matricula_servidor',
        'id_gestor_assinatura',
        'data_hora_assinatura_gestor',
        'historico',
        'rash',
        'status'
    ];


    public function usuario_cadastro_avaliacao_desempenho_servidor()
    {
        return $this->hasOne(Servidor::class, 'id', 'id_usuario_cadastro');
    }

    public function servidor_avaliacao_desempenho_servidor()
    {
        return $this->hasOne(Servidor::class, 'id', 'id_servidor');
    }

    public function gestor_assinatura_avaliacao_desempenho_servidor()
    {
        return $this->hasOne(Servidor::class, 'id', 'id_gestor_assinatura');
    }
}
