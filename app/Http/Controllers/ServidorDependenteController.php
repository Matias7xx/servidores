<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDependenteRequest;
use App\Models\ServidorDependente;
use App\Models\User;
use Illuminate\Http\Request;

class ServidorDependenteController extends Controller
{

    public function index()
    {
        $user = User::where('matricula', auth()->guard('web')->user()->matricula)
            ->first();

        // Busca os dependentes do servidor logado
        $dependentes = ServidorDependente::where('servidor_matricula', auth()->guard('web')->user()->matricula)
            ->where('status', 'A')
            ->orderBy('nome', 'asc')
            ->get();
        // Retorna uma view passando os dependentes
        return view('servidores.dependentes.list', compact('dependentes', 'user'));
    }

    public function create()
    {
        $user = User::where('matricula', auth()->guard('web')->user()->matricula)
            ->first();
        return view('servidores.dependentes.create', compact('user'));
    }

    public function store(StoreDependenteRequest $request)
    {
        if ($request->hasFile('anexo')) {
            $file = $request->file('anexo');

            // Gerar um nome único para o arquivo
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Armazenar o arquivo na pasta desejada, por exemplo, 'public/anexos'
            $path = $file->storeAs('public/anexos', $filename);

            // Passar o nome do arquivo para o campo 'anexo' no banco
            $validated['anexo'] = $filename;
        }
        if ($request['historico'] != "") {
            $historico = json_decode($request['historico'], true);
        } else {
            $historico = [];
        }

        $novaAtualizacao = [
            "usuario_matricula" => $request['matricula'],
            "data" => now(),
            "alteracao" => "Cadastro inicial do dependente"
        ];

        $historico['atualizacoes'][] = $novaAtualizacao;
        $validated['historico'] = json_encode($historico);

        $validated['servidor_matricula'] = $request['matricula'];
        $validated['tipo_dependente'] = $request['tipo_dependente'];
        $validated['nome'] = $request['nome'];
        $validated['cpf'] = $request['cpf'];
        $validated['sexo_dependente'] = $request['sexo_dependente'];
        $validated['data_nascimento'] = $request['data_nascimento'];
        $validated['documento'] = $request['documento'];
        $validated['historico'] = $request['historico'];
        $validated['status'] = $request['status'];

        $dependente = ServidorDependente::where('cpf', $validated['cpf'])
            ->where('servidor_matricula', $request['matricula'])
            ->first();
        if ($dependente) {

            if ($dependente->status == 'I') {
                return redirect()->back()->with([
                    'showConfirmation' => true,
                    'message' => 'Este dependente já está cadastrado, porém está inativo. Deseja reativá-lo?',
                    'dependenteId' => $dependente->id,
                    'confirmation' => true
                ])->withInput();
            }
            return redirect()->back()->with('error', 'O CPF do(a) dependente já foi cadastrado no sistema para o cpf do(a) servidor(a)!')->withInput();
        }

        $validated['created_at'] = now();
        $validated['updated_at'] = now();
        $validated['status'] = 'A';

        ServidorDependente::create($validated);

        return redirect()->route('servidores.servidor_dependentes_lista')->with('success', 'Dependente cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServidorDependente $servidorDependente)
    {
        $user = User::where('matricula', auth()->guard('web')->user()->matricula)
            ->first();

        // Busca os dependentes do servidor logado
        $dependentes = ServidorDependente::where('servidor_matricula', auth()->guard('web')->user()->matricula)
            ->where('status', 'I')
            ->orderBy('nome', 'asc')
            ->get();
        // Retorna uma view passando os dependentes
        return view('servidores.dependentes.list_inativo', compact('dependentes', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::where('matricula', auth()->guard('web')->user()->matricula)
            ->first();
        $servidorDependente = ServidorDependente::findOrFail($id);
        return view('servidores.dependentes.edit', compact('servidorDependente', 'user'));
    }

    public function update(StoreDependenteRequest $request)
    {
        $validated = $request->validated();
        $dependente = ServidorDependente::find($request['id']);

        if ($request->hasFile('documento')) {
            $file = $request->file('documento');

            // Gerar um nome único para o arquivo
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Armazenar o arquivo na pasta desejada, por exemplo, 'public/documentos'
            $path = $file->storeAs('public/doc_dependentes', $filename);

            // Passar o nome do arquivo para o campo 'documento' no banco
            $validated['documento'] = $filename;
        }

        // Verifica se houve alteracoes nos campos
        $hasChanges = false;
        $fieldsToCompare = [
            'servidor_matricula' => 'matricula',
            'tipo_dependente' => 'tipo_dependente',
            'nome' => 'nome',
            'cpf' => 'cpf',
            'sexo_dependente' => 'sexo_dependente',
            'data_nascimento' => 'datanascimento'
        ];

        if ($request->hasFile('documento')) {
            $fieldsToCompare['documento'] = 'documento';
        }

        $alteracoes = "";
        foreach ($fieldsToCompare as $dbField => $requestField) {
            if ($dependente->$dbField != $request[$requestField]) {
                $hasChanges = true;
                $alteracoes .= "[" .
                    'campo: ' . $dbField . ", " .
                    'valor_antigo: ' . $dependente->$dbField . ", " .
                    'valor_novo: ' . $request[$requestField];
            }
        }

        if (!$hasChanges) {
            return redirect()->back()->with('error', 'Nenhuma alteracao foi detectada.');
        }

        $historico = [];
        if ($dependente && $dependente->historico) {
            $historico = json_decode($dependente->historico, true);
        }
        $novaAtualizacao = [
            "usuario_id" => $request['id'],
            "data" => now(),
            "alteracao" => "Atualizacao dos dados do dependente" . $alteracoes
        ];

        $historico[] = $novaAtualizacao;
        $validated['historico'] = json_encode($historico);
        $validated['servidor_matricula'] = $request['matricula'];
        $validated['tipo_dependente'] = $request['tipo_dependente'];
        $validated['nome'] = $request['nome'];
        $validated['cpf'] = $request['cpf'];
        $validated['sexo_dependente'] = $request['sexo_dependente'];
        $validated['data_nascimento'] = $request['datanascimento'];

        $validated['updated_at'] = now();

        try {
            $dependente->update($validated);
            return redirect()->route('servidores.servidor_dependentes_lista')->with('success', 'Dependente atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar dependente!')->withInput();
        }
    }

    public function destroy(Request $request)
    {
        try {
            $historico = [];
            $dependente = ServidorDependente::findOrFail($request['id_dependente']);
            if ($dependente && $dependente->historico) {
                $historico = json_decode($dependente->historico, true);
            }

            $novaAtualizacao = [
                "usuario_matricula" => $request['matricula_servidor'],
                "data" => now(),
                "alteracao" => "Inativacao do(a) dependente"
            ];

            $historico[] = $novaAtualizacao;

            $dependente->update([
                'status' => 'I',
                'historico' => json_encode($historico),
                'updated_at' => now()
            ]);

            return redirect()->back()->with('success', 'Dependente inativado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao inativar dependente!');
        }
    }

    public function reativar(Request $request)
    {
        try {
            $historico = [];
            $dependente = ServidorDependente::findOrFail($request['id_dependente']);
            if ($dependente && $dependente->historico) {
                $historico = json_decode($dependente->historico, true);
            }

            $novaAtualizacao = [
                "usuario_matricula" => $request['matricula_servidor'],
                "data" => now(),
                "alteracao" => "Reativacao do(a) dependente"
            ];

            $historico[] = $novaAtualizacao;

            $dependente->update([
                'status' => 'A',
                'historico' => json_encode($historico),
                'updated_at' => now()
            ]);
            return redirect()->route('servidores.servidor_dependentes_lista')->with('success', 'Dependente reativado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao reativar dependente!');
        }
    }

    public function reativarDependente($id_dependente)
    {
        try {
            $historico = [];
            $dependente = ServidorDependente::findOrFail($id_dependente);
            if ($dependente && $dependente->historico) {
                $historico = json_decode($dependente->historico, true);
            }

            $novaAtualizacao = [
                "usuario_matricula" => auth()->guard('web')->user()->matricula,
                "data" => now(),
                "alteracao" => "Reativacao do(a) dependente"
            ];

            $historico[] = $novaAtualizacao;

            $dependente->update([
                'status' => 'A',
                'historico' => json_encode($historico),
                'updated_at' => now()
            ]);

            return redirect()->route('servidores.servidor_dependentes_lista')->with('success', 'Dependente reativado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao reativar dependente!');
        }
    }
}
