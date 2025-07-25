<div class="grid gap-6 md:grid-cols-3 mb-3">
    <div class="col-span-1 flex items-center">
        <h2 class="text-2xl font-semibold text-gray-700">
            Lista
        </h2>
    </div>
    <div class="col-span-2 flex items-center justify-end">
        <a href="{{ route('servidores.servidor_dependentes_create') }}" class="inline-flex items-center gap-1 bg-gray-600 text-white text-sm font-semibold rounded-full px-4 py-1 hover:bg-gray-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <nobr>Cadastrar novo dependente</nobr>
        </a>
        <a href="{{ route('servidores.servidor_dependentes_lista_inativo') }}" class="inline-flex items-center gap-1 bg-gray-600 text-white text-sm font-semibold rounded-full px-4 py-1 hover:bg-gray-700 transition ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <nobr>Listar inativos</nobr>
        </a>
    </div>
</div>

<div class="overflow-x-auto border border-gray-300 rounded-lg">
    <div class="bg-black text-white p-2 rounded-lg border-l-8" style="border-left-color: rgb(193,168,90);">
        <h2 class="text-xl font-semibold">
            Dependentes Ativos
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
                                <a href="{{ route('servidores.servidor_dependentes_edit', $dependente->id) }}"
                                    class="btn btn-xs btn-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    Editar
                                </a>
                                <form class="inline" action="{{ route('servidores.servidor_dependentes_inativar') }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="id_dependente" value="{{ $dependente->id }}">
                                    <input type="hidden" name="matricula_servidor"
                                        value="{{ $dependente->servidor_matricula }}">
                                    <button type="button" onclick="confirmarExclusao(this.form)"
                                        class="btn btn-xs btn-error">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        Excluir
                                    </button>
                                </form>
                                <script>
                                    function confirmarExclusao(form) {
                                        if (confirm("Tem certeza que deseja excluir este dependente?")) {
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
