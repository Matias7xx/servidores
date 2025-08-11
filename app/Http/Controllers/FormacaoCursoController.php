<?php

namespace App\Http\Controllers;

use App\Models\FormacaoCurso;
use Illuminate\Http\Request;

class FormacaoCursoController extends Controller
{
    public function getCursosByClasse($classe_id)
{
    $cursos = FormacaoCurso::where('classe_id', $classe_id)
              ->where('status', 'A')
              ->orderBy('curso')
              ->get(['id', 'curso']); // pegar só o necessário

    return response()->json($cursos);
}
}
