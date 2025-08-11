<?php

namespace App\Http\Controllers;

use App\Models\FormacaoClasse;
use Illuminate\Http\Request;

class FormacaoClasseController extends Controller
{
    public function getClassesByArea($area_id)
    {
        $classes = FormacaoClasse::where('area_id', $area_id)
            ->where('status', 'A')
            ->orderBy('classe')
            ->get(['id', 'classe']);  // pega só os campos necessários

        return response()->json($classes);
    }
}
