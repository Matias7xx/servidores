<div class="grid gap-6 md:grid-cols-2">
    <div class="col-span-1 flex items-center">
        <h2 class="text-2xl font-semibold text-gray-700">
            Avaliação de Desempenho do(a) Servidor(a)
        </h2>
    </div>

</div>

<hr class="my-2">

<div class="overflow-x-auto p-4">
    <table class="tabela-bonita table-zebra">
        <thead>
            <tr>
                <th></th>
                <th>Mês</th>
                <th>Ano</th>
                <th>C1</th>
                <th>C2</th>
                <th>C3</th>
                <th>C4</th>
                <th>C5</th>
                <th>Total</th>
                <th>Ficha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($avaliacao as $item)
                <tr class="text-black">
                    <th>{{ ($avaliacao->currentPage() - 1) * $avaliacao->perPage() + $loop->iteration }}</th>
                    <td>{{ $item->mes }}</td>
                    <td>{{ $item->ano }}</td>
                    <td>{{ $item->c1 }}</td>
                    <td>{{ $item->c2 }}</td>
                    <td>{{ $item->c3 }}</td>
                    <td>{{ $item->c4 }}</td>
                    <td>{{ $item->c5 }}</td>
                    <td>{{ $item->total }}</td>
                    <td>
                        
                        <a href="javascript:abrirPagina('{{ route('servidores.ficha_avaliacao_servidor', ['id' => $item->id_servidor, 'mes' => $item->mes, 'ano' => $item->ano]) }}', 600, 600)"
                            class="btn btn-success btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg> Abrir Ficha                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $avaliacao->links('pagination::tailwind') }}
    </div>
</div>
