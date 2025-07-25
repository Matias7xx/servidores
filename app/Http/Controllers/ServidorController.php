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
    public function edit()
    {
        $cidades = Cidade::all()->sortBy('nome');
        $estados = Estado::all()->sortBy('sigla');
        $servidor_config = ServidorConfig::all();
        $user = User::where('matricula',auth()->guard('web')->user()->matricula)
        ->first();

        $servidor = Servidor::where('matricula', auth()->guard('web')->user()->matricula)
            ->with('cargo_nome')
            ->with('cidade_nome')
            ->where('status', 'A')
            ->first();
        if (!$servidor) {
            return redirect()->back()->with('error', 'Servidor não encontrado');
        }
        return view('servidores.pessoais.editar', compact('servidor', 'cidades', 'estados', 'servidor_config', 'user'));
    }

    public function home()
    {
        $user = User::where('matricula',auth()->guard('web')->user()->matricula)->where('status', 'Ativo')->first();
        return view('home', compact('user'));
    }

    public function update(ServidorRequest $request)
    {
        $validated = $request->validated();

        $validated['cpf'] = $validated['cpf'];
        $validated['pasep'] = $request['pasep'];
        $validated['reservista'] = $request['reservista'];
        $validated['titulonumero'] = $request['titulonumero'];
        $validated['titulozona'] = $request['titulozona'];
        $validated['titulosecao'] = $request['titulosecao'];
        $validated['numerocnh'] = $request['numerocnh'];
        $validated['telefone_1'] = $request['telefone_1'];
        $validated['telefone_2'] = $request['telefone_2'] ? $request['telefone_2'] : null;
        $validated['cep'] = $request['cep'];
        $validated['conjuge_cpf'] = $request['conjuge_cpf'];
        $validated['sexo'] = $request['sexo'];
        $validated['orientacao'] = $request['orientacao'];
        $validated['datanascimento'] = $request['datanascimento'];
        $validated['pasep'] = $request['pasep'];
        $validated['reservista'] = $request['reservista'];
        $validated['religiao'] = $request['religiao'];
        $validated['pai'] = $request['pai'];
        $validated['mae'] = $request['mae'];
        $validated['alergia'] = $request['alergia'];
        $validated['nacionalidade'] = $request['nacionalidade'];
        $validated['naturalidade'] = $request['naturalidade'];
        $validated['tiposanguineo'] = $request['tiposanguineo'];
        $validated['fator_rh'] = $request['fator_rh'];
        $validated['titulonumero'] = $request['titulonumero'];
        $validated['titulozona'] = $request['titulozona'];
        $validated['titulosecao'] = $request['titulosecao'];
        $validated['numerocnh'] = $request['numerocnh'];
        $validated['categoriacnh'] = $request['categoriacnh'];
        $validated['tamanho_colete'] = $request['tamanho_colete'];
        $validated['grauinstrucao'] = $request['grauinstrucao'];
        $validated['tamanhocamisa'] = $request['tamanhocamisa'];
        $validated['cor_raca'] = $request['cor_raca'];
        $validated['telefone_1'] = $request['telefone_1'];
        $validated['telefone_2'] = $request['telefone_2'];
        $validated['cep'] = $request['cep'];
        $validated['estado'] = $request['estado'];
        $validated['cidade_id'] = $request['cidade_id'];
        $validated['bairro'] = $request['bairro'];
        $validated['rua'] = $request['rua'];
        $validated['numero'] = $request['numero'];
        $validated['complemento'] = $request['complemento'];
        $validated['email'] = $request['email'];
        $validated['estadocivil'] = $request['estadocivil'];
        $validated['conjuge'] = $request['conjuge'];
        $validated['conjuge_cpf'] = $request['conjuge_cpf'];
        $validated['updated_at'] = now();
        $validated['next_updated'] = now()->addDays(365);

        $servidor = Servidor::on('db_rh')->where('id', $request->id)->first();
        if (!$servidor) {
            return redirect()->back()->with('error', 'Servidor não encontrado');
        }
        $servidor->update($validated);
        return redirect()->back()->with('success', 'Dados atualizados com sucesso!');
    }
}
