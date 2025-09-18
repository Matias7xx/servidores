<?php

namespace App\Http\Controllers;

use App\Models\ServidorDependente;
use App\Models\User;
use Illuminate\Http\Request;

class ServidorDependenteController extends Controller
{
    /**
     * Converter sexo do formato do formulário (Masculino/Feminino) para padrão do banco (M/F) (está VARCHAR 2)
     */
    private function convertSexoToDatabase($sexo)
    {
        return ($sexo === 'Masculino') ? 'M' : 'F';
    }

    /**
     * Converter sexo do formato do banco (M/F) para exibição (Masculino/Feminino)
     */
    private function convertSexoFromDatabase($sexo)
    {
        return ($sexo === 'M') ? 'Masculino' : 'Feminino';
    }

    public function index(Request $request)
    {
        try {
            $user = User::where('matricula', auth()->guard('web')->user()->matricula)->first();

            $dependentes = ServidorDependente::where('servidor_matricula', auth()->guard('web')->user()->matricula)
                ->where('status', 'A')
                ->orderBy('nome', 'asc')
                ->get();

            $dependentes->each(function ($dependente) {
                $dependente->sexo_dependente = $this->convertSexoFromDatabase($dependente->sexo_dependente);
            });

            return response()->json([
                'success' => true,
                'data' => $dependentes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar dependentes'
            ], 500);
        }
    }

    public function create(Request $request)
    {
        try {
            $user = User::where('matricula', auth()->guard('web')->user()->matricula)->first();

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user,
                    'tipos_dependente' => ['Cônjuge', 'Filho(a)', 'Afilhado(a)', 'Pai', 'Mãe'],
                    'sexos' => ['Masculino', 'Feminino']
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar dados para criação'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nome' => 'required|string|max:255',
                'cpf' => 'required|string|max:11',
                'sexo_dependente' => 'required|string|in:Masculino,Feminino',
                'tipo_dependente' => 'required|string',
                'data_nascimento' => 'required|date',
                'anexo' => 'nullable|file|mimes:pdf|max:2048'
            ]);

            $validated = [];

            $historico = [];
            if ($request->filled('historico') && $request->historico != "") {
                $historico = json_decode($request->historico, true) ?? [];
            }

            $novaAtualizacao = [
                "usuario_matricula" => auth()->guard('web')->user()->matricula,
                "data" => now()->toISOString(),
                "alteracao" => "Cadastro inicial do dependente"
            ];

            if (!isset($historico['atualizacoes'])) {
                $historico['atualizacoes'] = [];
            }
            $historico['atualizacoes'][] = $novaAtualizacao;

            $validated['historico'] = json_encode($historico);
            $validated['servidor_matricula'] = auth()->guard('web')->user()->matricula;
            $validated['tipo_dependente'] = $request->input('tipo_dependente');
            $validated['nome'] = $request->input('nome');
            $validated['cpf'] = $request->input('cpf');
            $validated['sexo_dependente'] = $this->convertSexoToDatabase($request->input('sexo_dependente'));
            $validated['data_nascimento'] = $request->input('data_nascimento');
            $validated['status'] = 'A';
            $validated['created_at'] = now();
            $validated['updated_at'] = now();

            // Verificar se já existe
            $dependenteExistente = ServidorDependente::where('cpf', $validated['cpf'])
                ->where('servidor_matricula', auth()->guard('web')->user()->matricula)
                ->first();

            if ($dependenteExistente) {
                if ($dependenteExistente->status == 'I') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Este dependente já está cadastrado, porém está inativo.',
                        'action' => 'confirm_reactivate',
                        'dependente_id' => $dependenteExistente->id
                    ], 409);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'O CPF do(a) dependente já foi cadastrado no sistema!'
                ], 409);
            }

            // Handle file upload para normalizar o nome do arquivo para o nome original
            if ($request->hasFile('anexo')) {
                $file = $request->file('anexo');
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
                $cleanName = preg_replace('/[^A-Za-z0-9\-_.]/', '_', $nameWithoutExtension);

                $filename = $cleanName . '.' . $extension;
                $contador = 1;
                while (file_exists(storage_path('app/public/doc_dependentes/' . $filename))) {
                    $filename = $cleanName . '_' . $contador . '.' . $extension;
                    $contador++;
                }

                $path = $file->storeAs('public/doc_dependentes', $filename);
                $validated['documento'] = $filename;
            }

            $novoDependente = ServidorDependente::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Dependente cadastrado com sucesso!',
                'data' => $novoDependente
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro interno: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, ServidorDependente $servidorDependente = null)
    {
        try {
            $user = User::where('matricula', auth()->guard('web')->user()->matricula)->first();

            $dependentes = ServidorDependente::where('servidor_matricula', auth()->guard('web')->user()->matricula)
                ->where('status', 'I')
                ->orderBy('nome', 'asc')
                ->get();

            $dependentes->each(function ($dependente) {
                $dependente->sexo_dependente = $this->convertSexoFromDatabase($dependente->sexo_dependente);
            });

            return response()->json([
                'success' => true,
                'data' => $dependentes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar dependentes inativos'
            ], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $user = User::where('matricula', auth()->guard('web')->user()->matricula)->first();
            $servidorDependente = ServidorDependente::where('id', $id)
                ->where('servidor_matricula', auth()->guard('web')->user()->matricula)
                ->first();

            if (!$servidorDependente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dependente não encontrado'
                ], 404);
            }

            $servidorDependente->sexo_dependente = $this->convertSexoFromDatabase($servidorDependente->sexo_dependente);

            return response()->json([
                'success' => true,
                'data' => [
                    'dependente' => $servidorDependente,
                    'user' => $user,
                    'tipos_dependente' => ['Cônjuge', 'Filho(a)', 'Afilhado(a)', 'Pai', 'Mãe'],
                    'sexos' => ['Masculino', 'Feminino']
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar dependente'
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'nome' => 'required|string|max:255',
                'cpf' => 'required|string|max:11',
                'sexo_dependente' => 'required|string|in:Masculino,Feminino',
                'tipo_dependente' => 'required|string',
                'data_nascimento' => 'required|date',
                'anexo' => 'nullable|file|mimes:pdf|max:2048'
            ]);

            $dependente = ServidorDependente::where('id', $request['id'])
                ->where('servidor_matricula', auth()->guard('web')->user()->matricula)
                ->first();

            if (!$dependente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dependente não encontrado'
                ], 404);
            }

            $validated = [];

            // Handle file upload
            if ($request->hasFile('documento') || $request->hasFile('anexo')) {
                $file = $request->file('documento') ?? $request->file('anexo');
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
                $cleanName = preg_replace('/[^A-Za-z0-9\-_.]/', '_', $nameWithoutExtension);

                $filename = $cleanName . '.' . $extension;
                $contador = 1;
                while (file_exists(storage_path('app/public/doc_dependentes/' . $filename))) {
                    $filename = $cleanName . '_' . $contador . '.' . $extension;
                    $contador++;
                }

                $path = $file->storeAs('public/doc_dependentes', $filename);
                $validated['documento'] = $filename;
            }

            // Verifica se houve alterações nos campos
            $hasChanges = false;
            $fieldsToCompare = [
                'nome' => 'nome',
                'cpf' => 'cpf',
                'sexo_dependente' => 'sexo_dependente',
                'tipo_dependente' => 'tipo_dependente',
                'data_nascimento' => 'data_nascimento'
            ];

            if ($request->hasFile('documento') || $request->hasFile('anexo')) {
                $hasChanges = true;
            }

            $alteracoes = "";
            foreach ($fieldsToCompare as $dbField => $requestField) {
                $newValue = $request->$requestField;

                if ($dbField === 'sexo_dependente') {
                    $newValue = $this->convertSexoToDatabase($newValue);
                }

                if ($dependente->$dbField != $newValue) {
                    $hasChanges = true;
                    $alteracoes .= "[campo: $dbField, valor_antigo: {$dependente->$dbField}, valor_novo: $newValue] ";
                }
            }

            if (!$hasChanges) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nenhuma alteração foi detectada.'
                ], 400);
            }

            $historico = [];
            if ($dependente && $dependente->historico) {
                $historico = json_decode($dependente->historico, true);
            }

            $novaAtualizacao = [
                "usuario_matricula" => auth()->guard('web')->user()->matricula,
                "data" => now(),
                "alteracao" => "Atualização dos dados do dependente" . $alteracoes
            ];

            $historico[] = $novaAtualizacao;

            $validated['historico'] = json_encode($historico);
            $validated['nome'] = $request['nome'];
            $validated['cpf'] = $request['cpf'];
            $validated['sexo_dependente'] = $this->convertSexoToDatabase($request['sexo_dependente']);
            $validated['tipo_dependente'] = $request['tipo_dependente'];
            $validated['data_nascimento'] = $request['data_nascimento'];
            $validated['updated_at'] = now();

            $dependente->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Dependente atualizado com sucesso!',
                'data' => $dependente->fresh()
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar dependente'
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $dependente = ServidorDependente::where('id', $request['id_dependente'])
                ->where('servidor_matricula', auth()->guard('web')->user()->matricula)
                ->first();

            if (!$dependente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dependente não encontrado'
                ], 404);
            }

            $historico = [];
            if ($dependente && $dependente->historico) {
                $historico = json_decode($dependente->historico, true);
            }

            $novaAtualizacao = [
                "usuario_matricula" => auth()->guard('web')->user()->matricula,
                "data" => now(),
                "alteracao" => "Inativação do(a) dependente"
            ];

            $historico[] = $novaAtualizacao;

            $dependente->update([
                'status' => 'I',
                'historico' => json_encode($historico),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dependente inativado com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao inativar dependente'
            ], 500);
        }
    }

    public function reativar(Request $request)
    {
        try {
            $dependente = ServidorDependente::where('id', $request['id_dependente'])
                ->where('servidor_matricula', auth()->guard('web')->user()->matricula)
                ->first();

            if (!$dependente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dependente não encontrado'
                ], 404);
            }

            $historico = [];
            if ($dependente && $dependente->historico) {
                $historico = json_decode($dependente->historico, true);
            }

            $novaAtualizacao = [
                "usuario_matricula" => auth()->guard('web')->user()->matricula,
                "data" => now(),
                "alteracao" => "Reativação do(a) dependente"
            ];

            $historico[] = $novaAtualizacao;

            $dependente->update([
                'status' => 'A',
                'historico' => json_encode($historico),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dependente reativado com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao reativar dependente'
            ], 500);
        }
    }

    public function reativarDependente(Request $request, $id_dependente)
    {
        try {
            $dependente = ServidorDependente::where('id', $id_dependente)
                ->where('servidor_matricula', auth()->guard('web')->user()->matricula)
                ->first();

            if (!$dependente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dependente não encontrado'
                ], 404);
            }

            $historico = [];
            if ($dependente && $dependente->historico) {
                $historico = json_decode($dependente->historico, true);
            }

            $novaAtualizacao = [
                "usuario_matricula" => auth()->guard('web')->user()->matricula,
                "data" => now(),
                "alteracao" => "Reativação do(a) dependente"
            ];

            $historico[] = $novaAtualizacao;

            $dependente->update([
                'status' => 'A',
                'historico' => json_encode($historico),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dependente reativado com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao reativar dependente'
            ], 500);
        }
    }
}
