<?php

namespace App\Http\Controllers;

use App\Models\AvaliacaoDesempenhoServidor;
use App\Models\Servidor;
use Illuminate\Http\Request;

class AvaliacaoDesempenhoServidorController extends Controller
{
    public function index()
    {
        $avaliacao = AvaliacaoDesempenhoServidor::where('matricula_servidor', auth()->guard('web')->user()->matricula)
            ->with([
                'usuario_cadastro_avaliacao_desempenho_servidor:id,nome,matricula,cargo',
                'servidor_avaliacao_desempenho_servidor:id,nome,matricula,cargo',
                'gestor_assinatura_avaliacao_desempenho_servidor:id,nome,matricula,cargo',
            ])
            ->where('status', 'A')
            ->orderBy('ano', 'desc')
            ->orderBy('mes', 'desc')
            ->paginate(10); // Paginação de 10 por página
        return view('servidores.avaliacao.desempenho.list_servidor', compact('avaliacao'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id, $mes, $ano)
    {
        // Busca os dependentes do servidor logado, com paginação
        $avaliacao = AvaliacaoDesempenhoServidor::where('id_servidor', $id)
            ->with([
                'usuario_cadastro_avaliacao_desempenho_servidor:id,nome,matricula,cargo',
                'gestor_assinatura_avaliacao_desempenho_servidor:id,nome,matricula,cargo',
                'servidor_avaliacao_desempenho_servidor' => function ($query) {
                    $query->select('id', 'nome', 'matricula', 'cargo', 'delegacia_id')
                        ->with((['unidadeServidor' => function ($query) {
                                $query->select('id_delegacia','nome');
                            }, 'cargo_nome' => function ($query) {
                                $query->select('codigo', 'nome');
                            }]
                            )
                        );
                },
            ])
            ->where('mes', $mes)
            ->where('ano', $ano)
            ->where('status', 'A')
            ->first();
        return view('servidores.avaliacao.desempenho.ficha_avaliacao_servidor', compact('avaliacao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AvaliacaoDesempenhoServidor $avaliacaoDesempenhoServidor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AvaliacaoDesempenhoServidor $avaliacaoDesempenhoServidor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AvaliacaoDesempenhoServidor $avaliacaoDesempenhoServidor)
    {
        //
    }
}
