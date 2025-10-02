<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServidorFormacaoRequest;
use App\Http\Requests\ServidorFormacaoRequestUpdate;
use App\Models\FormacaoArea;
use App\Models\FormacaoClasse;
use App\Models\FormacaoCurso;
use App\Models\ServidorFormacao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServidorFormacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $formacao = ServidorFormacao::where('servidor_matricula', auth()->guard('web')->user()->matricula)
            ->where(function ($query) {
                $query->where('status', 'A')
                    ->orWhereNull('status')
                    ->orWhere('status', '');
            })
            ->select('id', 'curso_id', 'data_conclusao', 'anexo_frente', 'anexo_verso', 'status', 'validacao_status')
            ->with([
                'formacaoServidorCurso' => function ($query) {
                    $query->select('id', 'curso', 'classe_id', 'sub_categoria_id')
                        ->with([
                            'formacaoClasse' => function ($query) {
                                $query->select('id', 'classe', 'area_id')
                                    ->with([
                                        'formacaoArea' => function ($query) {
                                            $query->select('id', 'area');
                                        }
                                    ]);
                            },
                            'subcategoria' => function ($query) {
                                $query->select('id', 'nome', 'formacao_categoria_id')
                                    ->with([
                                        'categoria' => function ($query) {
                                            $query->select('id', 'nome');
                                        }
                                    ]);
                            }
                        ]);
                }
            ])
            ->orderBy('data_conclusao', 'desc')
            ->get();

            return response()->json([
                'success' => true,
                'data' => $formacao
            ]);
    }


    function convertToUtf8($data)
    {
        if (is_array($data)) {
            return array_map([$this, 'convertToUtf8'], $data);
        } elseif (is_string($data)) {
            return mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        } else {
            return $data;
        }
    }

    public function extractData(array $jsonArray)
    {
        foreach ($jsonArray as $item) {
            if (isset($item['type']) && $item['type'] === 'table' && isset($item['data'])) {
                return $item['data'];
            }
        }
        return []; // Retorna array vazio se não encontrar
    }

    public function create()
    {
        $areas = FormacaoArea::where('status', 'A')
            ->orderBy('area')
            ->get();

            return response()->json([
                'success' => true,
                'data' => $areas
            ]);
    }

    public function store(ServidorFormacaoRequest $request)
    {

        $validated = $request->validated();

        // Lida com o upload de arquivo frente, se houver
        if ($request->hasFile('anexo_frente')) {
            $file = $request->file('anexo_frente');

            // Gera um nome único para o arquivo
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Armazena o arquivo em 'storage/app/public/formacao_academica'
            //$path = $file->storeAs('public/formacao_academica', $filename);

            Storage::disk('s3')->put('diplomas/' . $filename, file_get_contents($file));
            //Storage::disk('local')->put('example.txt', 'This is sample content.');

            // Define o nome do arquivo no array validado
            $validated['anexo_frente'] = $filename;
        }

        // Lida com o upload de arquivo verso, se houver
        if ($request->hasFile('anexo_verso')) {
            $file = $request->file('anexo_verso');

            // Gera um nome único para o arquivo
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Armazena o arquivo em 'storage/app/public/formacao_academica'
            Storage::disk('s3')->put('diplomas/' . $filename, file_get_contents($file));

            // Define o nome do arquivo no array validado
            $validated['anexo_verso'] = $filename;
        }

        // Decodifica e atualiza o histórico
        $historico = [];

        if (!empty($request['historico'])) {
            $historico = json_decode($request['historico'], true);
        }

        $novaAtualizacao = [
            "matricula" => $request['matricula'],
            "data" => now(),
            "alteracao" => "Cadastro inicial da formacao academica"
        ];

        $historico['atualizacoes'][] = $novaAtualizacao;
        $validated['historico'] = json_encode($historico);

        // Preenche os demais campos obrigatórios
        $validated['servidor_id'] = $request['servidor_id'];
        $validated['servidor_matricula'] = $request['matricula'];
        $validated['curso_id'] = $request['curso_id'];
        $validated['data_conclusao'] = $request['dataconclusao'];
        $validated['obs'] = $request['obs'];
        $validated['status'] = 'A';

        // Cria o registro
        ServidorFormacao::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Formação acadêmica cadastrada com sucesso!'
            ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(ServidorFormacao $servidorFormacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $areas = FormacaoArea::where('status', 'A')
            ->orderBy('area')
            ->get();

        $servidorFormacao = ServidorFormacao::where('id', $id)
            ->select('id', 'curso_id', 'data_conclusao', 'anexo_frente', 'anexo_verso', 'obs', 'status', 'validacao_status')
            ->with([
                'formacaoServidorCurso' => function ($query) {
                    $query->select('id', 'curso', 'classe_id')
                        ->with([
                            'formacaoClasse' => function ($query) {
                                $query->select('id', 'classe', 'area_id')
                                    ->with([
                                        'formacaoArea' => function ($query) {
                                            $query->select('id', 'area');
                                        }
                                    ]);
                            }
                        ]);
                }
            ])
            ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => [
                    'areas' => $areas,
                    'servidorFormacao' => $servidorFormacao
                ]
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServidorFormacaoRequestUpdate $request, ServidorFormacao $servidorFormacao)
    {
        $validated = $request->validated();

        try {
            $needsUpdate = false;
            $alteracoes = [];

            if ($servidorFormacao->curso_id != $request['curso_id']) {
                $needsUpdate = true;
                $alteracoes[] = "Alteracao do curso";
            }
            if ($servidorFormacao->data_conclusao != $request['dataconclusao']) {
                $needsUpdate = true;
                $alteracoes[] = "Alteracao da data de conclusao";
            }
            if ($servidorFormacao->obs != $request['obs']) {
                $needsUpdate = true;
                $alteracoes[] = "Alteracao das observacoes";
            }
            if ($request->hasFile('anexo_frente')) {
                $needsUpdate = true;
                $alteracoes[] = "Atualizacao do anexo frente";
            }
            if ($request->hasFile('anexo_verso')) {
                $needsUpdate = true;
                $alteracoes[] = "Atualizacao do anexo verso";
            }

            if (!$needsUpdate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nenhuma alteração foi realizada.'
                ]);
            }

            if ($request->hasFile('anexo_frente')) {
                $file = $request->file('anexo_frente');
                $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/formacao_academica', $filename);
                $validated['anexo_frente'] = $filename;
            }

            if ($request->hasFile('anexo_verso')) {
                $file = $request->file('anexo_verso');
                $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/formacao_academica', $filename);
                $validated['anexo_verso'] = $filename;
            }

            $historico = [];
            if (!empty($request['historico'])) {
                $historico = json_decode($request['historico'], true) ?: [];
            }

            if (!isset($historico['atualizacoes'])) {
                $historico['atualizacoes'] = [];
            }

            $novaAtualizacao = [
                "usuario_matricula" => $request['matricula'],
                "data" => now(),
                "alteracao" => implode(", ", $alteracoes)
            ];

            $historico['atualizacoes'][] = $novaAtualizacao;

            $updateData = [
                'curso_id' => $request['curso_id'],
                'data_conclusao' => $request['dataconclusao'],
                'obs' => $request['obs'],
                'status' => 'A',
                'historico' => json_encode($historico)
            ];

            if (isset($validated['anexo_frente'])) {
                $updateData['anexo_frente'] = $validated['anexo_frente'];
            }

            if (isset($validated['anexo_verso'])) {
                $updateData['anexo_verso'] = $validated['anexo_verso'];
            }

            $servidorFormacao->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Formação acadêmica atualizada com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar formação acadêmica',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServidorFormacao $servidorFormacao)
    {
        //
    }
}
