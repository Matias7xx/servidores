<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Cargo;
use App\Models\Unidade;
use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{
    use HasFactory;
    protected $connection = 'db_rh';
    protected $table = 'servidor';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'nome',
        'matricula',
        'status',
        'status_ep',
        'tipo',
        'situacao',
        'cargo',
        'classe',
        'nivel',
        'created_at',
        'updated_at',
        'next_updated',
        'cidade',
        'estado',
        'email',
        'telefone_2',
        'telefone_1',
        'pai',
        'mae',
        'nacionalidade',
        'estadocivil',
        'raca',
        'sexo',
        'orientacao',
        'datanascimento',
        'naturalidade',
        'conjuge',
        'conjuge_cpf',
        'identidadenumero',
        'titulonumero',
        'titulozona',
        'titulosecao',
        'cpf',
        'reservista',
        'grauinstrucao',
        'pasep',
        'identfuncional',
        'datanomeacao',
        'dataexercicio',
        'dataposse',
        'cep',
        'rua',
        'numero',
        'bairro',
        'complemento',
        'obs',
        'foto',
        'rash',
        'religiao',
        'numerocnh',
        'categoriacnh',
        'tiposanguineo',
        'fator_rh',
        'tamanhocamisa',
        'senha',
        'dp_select',
        'senha_assinatura',
        'historico',
        'ferias_bloqueio',
        'tamanho_colete',
        'pass_verific',
        'alergia',
        'cor_raca',
        'img_servidor',
        'dependentes',
        'delegacia_id',
        'api_token',
        'setor_id'
    ];

    public function unidadeServidor()
    {
        return $this->belongsTo(Unidade::class, 'delegacia_id', 'id_delegacia');
    }

    public function cargo_nome()
    {
        return $this->belongsTo(Cargo::class, 'cargo', 'codigo');
    }

    public function cidade_nome()
    {
        return $this->belongsTo(Cidade::class, 'cidade', 'codigo');
    }
}
