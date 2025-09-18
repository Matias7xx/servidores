<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Estado;
use App\Models\Servidor;
use Illuminate\Http\Request;
use App\Models\ServidorConfig;
use App\Models\User;

class ServidorController extends Controller
{
    public function home()
    {
        try {
            $user = User::where('matricula', auth()->guard('web')->user()->matricula)
                    ->where('status', 'Ativo')
                    ->first();

            return view('vue-app')->with([
                'user' => $user,
                'userData' => $user
            ]);

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Erro ao carregar dados do usuário');
        }
    }

    public function edit(Request $request)
    {
        try {
            $cidades = Cidade::all()->sortBy('nome')->values();
            $estados = Estado::all()->sortBy('sigla')->values();
            $servidor_config = ServidorConfig::all()->values();
            $user = User::where('matricula', auth()->guard('web')->user()->matricula)->first();

            $servidor = Servidor::where('matricula', auth()->guard('web')->user()->matricula)
                ->with('cargo_nome')
                ->with('cidade_nome')
                ->where('status', 'A')
                ->first();

            if (!$servidor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Servidor não encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'servidor' => $servidor,
                    'cidades' => $cidades,
                    'estados' => $estados,
                    'servidor_config' => $servidor_config,
                    'user' => $user
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $idServidor = $request->id;

            if (!$idServidor) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID do servidor é obrigatório'
                ], 400);
            }

            $servidor = Servidor::on('db_rh')->where('id_servidor', $idServidor)->first();

            if (!$servidor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Servidor não encontrado'
                ], 404);
            }

            $updateData = [];

            $fieldMapping = [
                'orientacao' => 'orientacao',
                'datanascimento' => 'datanascimento',
                'reservista' => 'reservista',
                'pai' => 'pai',
                'mae' => 'mae',
                'pasep' => 'pasep',
                'alergia' => 'alergia',
                'nacionalidade' => 'nacionalidade',
                'religiao' => 'religiao',
                'naturalidade' => 'naturalidade',
                'tiposanguineo' => 'tiposanguineo',
                'fator_rh' => 'fator_rh',
                'titulonumero' => 'titulonumero',
                'titulozona' => 'titulozona',
                'titulosecao' => 'titulosecao',
                'tamanho_colete' => 'tamanho_colete',
                'numerocnh' => 'numerocnh',
                'categoriacnh' => 'categoriacnh',
                'grauinstrucao' => 'grauinstrucao',
                'tamanhocamisa' => 'tamanhocamisa',
                'cor_raca' => 'cor_raca',
                'telefone_1' => 'telefone_1',
                'telefone_2' => 'telefone_2',
                'email' => 'email',
                'cep' => 'cep',
                'bairro' => 'bairro',
                'rua' => 'rua',
                'numero' => 'numero',
                'complemento' => 'complemento',
                'estadocivil' => 'estadocivil',
                'conjuge' => 'conjuge',
                'cidade_id' => 'cidade',
            ];

            foreach ($fieldMapping as $vueField => $dbField) {
                if ($request->has($vueField) && $request->$vueField !== null) {
                    $updateData[$dbField] = $request->$vueField;
                }
            }

            if ($request->has('estado') && $request->estado !== null) {
                if (strlen($request->estado) == 2) {
                    $updateData['estado'] = $request->estado;
                } else {
                    $updateData['estado'] = $request->estado;
                }
            }

            $servidor->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Dados atualizados com sucesso!',
                'data' => $servidor->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar dados',
                'error' => config('app.debug') ? $e->getMessage() : 'Erro interno do servidor'
            ], 500);
        }
    }
}
