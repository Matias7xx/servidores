<div class="grid gap-6 md:grid-cols-3 mb-3">
    <div class="col-span-1 flex items-center">
        <h2 class="text-2xl font-semibold text-gray-700">
            Lista
        </h2>
    </div>
    <div class="col-span-2 flex items-center justify-end">
        <a href="{{ route('servidores.servidor_dependentes_lista') }}" class="inline-flex items-center gap-1 bg-gray-600 text-white text-sm font-semibold rounded-full px-4 py-1 hover:bg-gray-700 transition ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
            </svg>
            <nobr>Voltar para a lista de ativos</nobr>
        </a>
    </div>
</div>

<div class="overflow-x-auto border border-gray-300 rounded-lg">
    <div class="bg-black text-white p-2 rounded-lg border-l-8" style="border-left-color: rgb(193,168,90);">
        <h2 class="text-xl font-semibold">
            Dependentes <strong class="text-red-600"> Inativos</strong>
        </h2>
    </div>
    <div>
        <table class="table table-xs">
            <thead>
                <tr>
                    <th></th>
                    <th>Nome</th>
                    <th>Sexo</th>
                    <th>Parentesco</th>
                    <th>Data Nascimento</th>
                    <th>CPF</th>
                    <th>Anexo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dependentes as $dependente)
                    <tr class="text-black">
                        <th>{{ $loop->iteration }}</th>
                        <td>{{ $dependente->nome }}</td>
                        <td>{{ $dependente->sexo_dependente == 'F' ? 'Feminino' : 'Masculino' }}</td>
                        <td>{{ $dependente->tipo_dependente }}</td>
                        <td>{{ date('d/m/Y', strtotime($dependente->data_nascimento)) }}</td>
                        <td>{{ $dependente->cpf }}</td>
                        <td>
                            @if ($dependente->documento)
                                <a href='javascript:abrirPagina("storage/doc_dependentes/{{ $dependente->documento }}", 600, 600)'
                                    class="btn btn-xs btn-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    Ver Anexo
                                </a>
                            @else
                                Sem anexo
                            @endif
                        </td>
                        <td>
                            <div class="flex space-x-2">
                                <form class="inline" action="{{ route('servidores.dependentes.reativar') }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="id_dependente" value="{{ $dependente->id }}">
                                    <input type="hidden" name="matricula_servidor"
                                        value="{{ $dependente->servidor_matricula }}">
                                    <button type="button" onclick="confirmarReativar(this.form)"
                                        class="btn btn-xs btn-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Reativar
                                    </button>
                                </form>
                                <script>
                                    function confirmarReativar(form) {
                                        if (confirm("Tem certeza que deseja reativar este dependente?")) {
                                            form.submit();
                                        }
                                    }
                                </script>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
