<?php

namespace Database\Seeders;

use App\Models\Cidade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Carrega os dados do JSON
        $jsonPath = database_path('seeders/cidades.json');
        $conteudo = file_get_contents($jsonPath);
        $json = json_decode($conteudo, true);

        // Verifica se o JSON é válido e contém a chave 'data'
        if (!isset($json['data']) || !is_array($json['data'])) {
            throw new \Exception('Erro: Arquivo JSON inválido ou chave "data" ausente.');
        }

        $cidades = $json['data']; // Acessa o array dentro de 'data'

        foreach ($cidades as $cidade) {
            if (isset($cidade['nome'], $cidade['codigo'], $cidade['uf'])) {
                Cidade::create([
                    'nome' => $cidade['nome'],
                    'codigo' => $cidade['codigo'],
                    'uf' => $cidade['uf'],
                ]);
            } else {
                Log::warning('Registro inválido encontrado:', $cidade);
            }
        }
    }
}
