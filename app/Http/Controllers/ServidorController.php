<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Estado;
use App\Models\Servidor;
use Illuminate\Http\Request;
use App\Models\ServidorConfig;
use App\Http\Requests\ServidorRequest;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Http;

class ServidorController extends Controller
{

    public function home()
    {
        try {
            $user = User::where('matricula', auth()->guard('web')->user()->matricula)
                    ->where('status', 'Ativo')
                    ->first();

            // retorna a view Vue com os dados do usuário
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
            // Se for uma requisição AJAX/fetch (do Vue), retorna JSON
            if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
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
            }

            // Se for navegação normal (F5, digitou URL, etc.), retorna a view Vue
            $user = User::where('matricula', auth()->guard('web')->user()->matricula)
                    ->where('status', 'Ativo')
                    ->first();

            return view('vue-app')->with([
                'user' => $user,
                'userData' => $user
            ]);

        } catch (\Exception $e) {
            // Se for AJAX, retorna erro JSON
            if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro interno do servidor',
                    'error' => $e->getMessage()
                ], 500);
            }

            // Se for navegação normal, redireciona
            return redirect()->route('home')->with('error', 'Erro ao carregar dados do usuário');
        }
    }

    public function update(Request $request)
    {
        try {
            // Debug: Log dos dados recebidos
            \Log::info('Dados recebidos no update:', $request->all());

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

            //Apenas campos que EXISTEM no banco
            $updateData = [];

            // Mapeamento: campo_do_vue => campo_do_banco
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
                'cidade_id' => 'cidade', // Mapear cidade_id para cidade
            ];

            foreach ($fieldMapping as $vueField => $dbField) {
                if ($request->has($vueField) && $request->$vueField !== null) {
                    $updateData[$dbField] = $request->$vueField;
                }
            }

            // TRATAMENTO PARA O ESTADO
            if ($request->has('estado') && $request->estado !== null) {
                // Se o valor recebido já é uma sigla (2 caracteres), usar diretamente
                if (strlen($request->estado) == 2) {
                    $updateData['estado'] = $request->estado;
                } else {
                    // Se recebeu um nome/sigla do select, usar diretamente
                    $updateData['estado'] = $request->estado;
                }
            }

            // Debug: Log dos dados que serão atualizados
            \Log::info('Dados para atualização:', $updateData);

            // Atualizar dados
            $servidor->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Dados atualizados com sucesso!',
                'data' => $servidor->fresh()
            ]);

        } catch (\Exception $e) {
            \Log::error('Erro no update:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar dados',
                'error' => config('app.debug') ? $e->getMessage() : 'Erro interno do servidor'
            ], 500);
        }
    }
}
