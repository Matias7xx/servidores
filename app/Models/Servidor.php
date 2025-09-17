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
    protected $primaryKey = 'id_servidor';

    public $timestamps = false;

    protected $fillable = [
        'nome', 'matricula', 'status', 'status_ep', 'tipo', 'situacao', 'cargo', 'funcao',
        'classe', 'nivel', 'datadaedicao', 'cidade', 'estado', 'email', 'telefone_1',
        'telefone_2', 'celular', 'pai', 'mae', 'nacionalidade', 'estadocivil', 'raca',
        'sexo', 'orientacao', 'datanascimento', 'naturalidade', 'conjuge', 'identidadenumero',
        'titulonumero', 'titulozona', 'titulosecao', 'cpf', 'reservista', 'grauinstrucao',
        'descinstrucao', 'situacaoformacao', 'carteirasaude', 'pasep', 'identfuncional',
        'datanomeacao', 'dataexercicio', 'dataposse', 'cep', 'rua', 'numero', 'bairro',
        'complemento', 'obs', 'foto', 'rash', 'religiao', 'outrareligiao', 'numerocnh',
        'categoriacnh', 'validadecnh', 'tiposanguineo', 'fator_rh', 'tamanhocamisa', 'senha',
        'dp_select', 'img_funcional', 'senha_assinatura', 'mes_req_ferias', 'historico',
        'ferias_bloqueio', 'tamanho_colete', 'pass_verific', 'alergia', 'cor_raca',
        'img_servidor', 'dependentes', 'password'
    ];

    protected $dates = [
        'datanascimento',
        'datanomeacao',
        'dataexercicio',
        'dataposse',
        'validadecnh',
        'datadaedicao'
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
