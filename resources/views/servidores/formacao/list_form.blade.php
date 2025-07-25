<div class="grid gap-6 md:grid-cols-3 mb-3">
    <div class="col-span-2 flex items-center">
        <h2 class="text-2xl font-semibold text-gray-700">
            Lista
        </h2>
    </div>
    <div class="col-span-1 flex items-center justify-end">
        <a href="{{ route('servidores.formacao.create') }}"
            class="inline-flex items-center gap-1 bg-gray-600 text-white text-sm font-semibold rounded-full px-4 py-1 hover:bg-gray-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Cadastrar nova formação acadêmica
        </a>
    </div>
</div>

<div class="overflow-x-auto border border-gray-300 rounded-lg">
    <div class="bg-black text-white p-2 rounded-lg border-l-8" style="border-left-color: rgb(193,168,90);">
        <h2 class="text-xl font-semibold">
            Formações acadêmicas do(a) servidor(a)
        </h2>
    </div>
    <div>
        <table class="table table-xs">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Área/Classe</th>
                    <th>Categoria</th>
                    <th>Curso</th>
                    <th>Data Conclusão</th>
                    <th>Certificado</th>
                    <th>Editar</th>
                    <th>Validação</th>
                    <th>status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($formacao as $index => $item)
                    <tr @if(empty($item->status)) style="color: red; font-weight: bold;" @endif>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            {{ $item->formacaoServidorCurso->formacaoClasse->formacaoArea->area ?? '-' }}
                         / 
                            {{ $item->formacaoServidorCurso->formacaoClasse->classe ?? '-' }}
                        </td>
                        <td>
                            {{ $item->formacaoServidorCurso->subcategoria->categoria->nome ?? '-' }}
                         / 
                            {{ $item->formacaoServidorCurso->subcategoria->nome ?? '-' }}
                        </td>
                        <td>
                            {{ $item->formacaoServidorCurso->curso ?? '-' }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($item->data_conclusao)->format('d/m/Y') ?? '-' }}
                        </td>
                        <td>
                            <nobr>
                                @if (!empty($item->anexo_frente))
                                    <a href='javascript:abrirPagina("{{ Storage::disk('s3')->temporaryUrl("diplomas/$item->anexo_frente", now()->addMinutes(5)); }}", 600, 600)'
                                        class="btn btn-xs btn-info">
                                        Frente
                                    </a>
                                @endif
                                @if (!empty($item->anexo_verso))
                                    <a href='javascript:abrirPagina("{{ Storage::disk('s3')->temporaryUrl("diplomas/$item->anexo_verso", now()->addMinutes(5)); }}", 600, 600)'
                                        class="btn btn-xs btn-info">
                                        Verso
                                    </a>
                                @endif
                            </nobr>
                        </td>
                        <td>
                            <a href="{{ route('servidores.formacao.edit', $item->id) }}"
                                class="btn btn-xs btn-warning">
                                Editar
                            </a>
                        </td>
                        <td>
                            @if ($item->validacao_status == 'A' || $item->validacao_status == '' || $item->validacao_status == null)
                                <font color="red"><b>Aguardando</b></font>
                            @else
                                <font color="green"><b>Válido</b></font>
                            @endif
                        </td>
                        <td>
                            @if (empty($item->status))
                                <span style="color: red; font-weight: bold;">Recuperado</span>
                            @else
                                <span style="color: green; font-weight: bold;">Ativo</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-gray-500 py-4">Nenhuma formação cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>