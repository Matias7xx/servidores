<?php

namespace App\Http\Controllers;

use App\Models\AvaliacaoDesempenhoGestor;
use Illuminate\Http\Request;

class AvaliacaoDesempenhoGestorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $avaliacao = AvaliacaoDesempenhoGestor::where('matricula_servidor', auth()->guard('web')->user()->matricula)
            ->with([
                'usuario_cadastro_avaliacao_desempenho_servidor:id,nome,matricula,cargo',
                'servidor_avaliacao_desempenho_servidor:id,nome,matricula,cargo',
                'gestor_assinatura_avaliacao_desempenho_servidor:id,nome,matricula,cargo',
            ])
            ->where('status', 'A')
            ->orderBy('ano', 'desc')
            ->orderBy('mes', 'desc')
            ->paginate(10); // Paginação de 10 por página
        return view('servidores.avaliacao.desempenho.list_gestor', compact('avaliacao'));
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
    public function show(AvaliacaoDesempenhoGestor $avaliacaoDesempenhoGestor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AvaliacaoDesempenhoGestor $avaliacaoDesempenhoGestor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AvaliacaoDesempenhoGestor $avaliacaoDesempenhoGestor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AvaliacaoDesempenhoGestor $avaliacaoDesempenhoGestor)
    {
        //
    }
}
