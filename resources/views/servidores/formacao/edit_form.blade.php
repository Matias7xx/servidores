@extends('layouts.app')

@section('conteudo')
<main class="h-screen flex flex-col overflow-y-auto px-4">
    <div class="mt-16 mb-2 flex-1 w-full px-6 bg-white">

        {{-- ALERTAS DE SUCESSO --}}
        @if (session('success'))
            <div id="toast-success"
                class="fixed top-4 right-4 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-green-100 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800"
                role="alert">
                <div
                    class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                </div>
                <div class="ms-3 text-sm font-normal">{{ session('success') }}</div>
                <button type="button" onclick="this.closest('[role=alert]').remove()"
                    class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif

        {{-- ALERTAS DE ERRO --}}
        @if (session('error'))
            <div id="toast-danger"
                class="fixed top-4 right-4 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-red-100 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800"
                role="alert">
                <div
                    class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                    </svg>
                </div>
                <div class="ms-3 text-sm font-normal">{{ session('error') }}</div>
                <button type="button" onclick="this.closest('[role=alert]').remove()"
                    class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif

        <form action="{{ route('servidores.formacao.update', $servidorFormacao->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="matricula" value="{{ auth()->user()->matricula }}">
            <input type="hidden" name="id" value="{{ $servidorFormacao->id }}">

            <div class="grid gap-6 md:grid-cols-3 mb-3">
                <div class="col-span-2 flex items-center">
                    <h2 class="text-2xl font-semibold text-gray-700">Editar</h2>
                </div>
            </div>

            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <div class="bg-black text-white p-2 rounded-lg border-l-8" style="border-left-color: rgb(193,168,90);">
                    <h2 class="text-xl font-semibold">Formação acadêmica</h2>
                </div>
                <div class="p-3">

                    {{-- ÁREA --}}
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label class="label dark:text-gray-700">Área</label>
                            <select name="area_id" id="area_id" class="w-full border border-gray-300 rounded-lg p-1">
                                @if ($servidorFormacao->formacaoServidorCurso)
                                    <option value="{{ $servidorFormacao->formacaoServidorCurso->formacaoClasse->formacaoArea->id }}">
                                        {{ $servidorFormacao->formacaoServidorCurso->formacaoClasse->formacaoArea->area }}
                                    </option>
                                @else
                                    <option value="">Selecione a área</option>
                                @endif
                                @foreach ($areas as $area)
                                    <option value="{{ $area['id'] }}">{{ $area['area'] }}</option>
                                @endforeach
                            </select>
                            @error('area_id') <span class="text-error text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- CLASSE --}}
                        <div>
                            <label class="label dark:text-gray-700">Classe</label>
                            <select name="classe_id" id="classe_id" class="w-full border-gray-300 rounded-lg p-1">
                                @if ($servidorFormacao->formacaoServidorCurso)
                                    <option value="{{ $servidorFormacao->formacaoServidorCurso->formacaoClasse->id }}">
                                        {{ $servidorFormacao->formacaoServidorCurso->formacaoClasse->classe }}
                                    </option>
                                @endif
                            </select>
                            @error('classe_id') <span class="text-error text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- CURSO / OBSERVAÇÃO --}}
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label class="label dark:text-gray-700">Curso</label>
                            <select name="curso_id" id="curso_id" class="w-full border-gray-300 rounded-lg p-1">
                                @if ($servidorFormacao->formacaoServidorCurso)
                                    <option value="{{ $servidorFormacao->formacaoServidorCurso->id }}">
                                        {{ $servidorFormacao->formacaoServidorCurso->curso }}
                                    </option>
                                @endif
                            </select>
                            @error('curso_id') <span class="text-error text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="label dark:text-gray-700">Observação</label>
                            <input type="text" name="obs" value="{{ $servidorFormacao->obs }}"
                                class="w-full border-gray-300 rounded-lg p-1" />
                            @error('obs') <span class="text-error text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- DATA / ANEXOS --}}
                    <div class="grid gap-6 md:grid-cols-3">
                        <div>
                            <label class="label dark:text-gray-700">Data Conclusão</label>
                            <input type="date" name="dataconclusao" value="{{ $servidorFormacao->data_conclusao }}"
                                class="w-full border-gray-300 rounded-lg p-1" />
                            @error('dataconclusao') <span class="text-error text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="label dark:text-black text-sm text-red-600">Substituir Certificado frente (.pdf)</label>
                            <input type="file" name="anexo_frente" accept=".pdf"
                                class="file-input file-input-bordered w-full h-8 dark:text-black {{ $errors->has('anexo_frente') ? 'border-red-500' : '' }}" />
                            @error('anexo_frente') <span class="text-error text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="label dark:text-black text-sm text-red-600">Substituir Certificado verso (.pdf)</label>
                            <input type="file" name="anexo_verso" accept=".pdf"
                                class="file-input file-input-bordered w-full h-8 dark:text-black {{ $errors->has('anexo_verso') ? 'border-red-500' : '' }}" />
                            @error('anexo_verso') <span class="text-error text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- BOTÕES --}}
                    <div class="flex justify-end space-x-4 mt-6">
                        <button type="submit"
                            class="inline-flex items-center gap-1 bg-green-600 text-white text-sm font-semibold rounded-full px-4 py-1 hover:bg-green-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                            </svg>
                            Atualizar
                        </button>
                        <a href="{{ route('servidores.formacao.list') }}"
                            class="inline-flex items-center gap-1 bg-gray-600 text-white text-sm font-semibold rounded-full px-4 py-1 hover:bg-gray-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                            </svg>
                            Voltar para a lista
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const alert = document.getElementById('toast-success') || document.getElementById('toast-danger');
    if (alert) {
        setTimeout(() => {
            alert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    }

    const selectArea = document.getElementById('area_id');
    const selectClasse = document.getElementById('classe_id');
    const selectCurso = document.getElementById('curso_id');

    selectArea.addEventListener('change', function () {
        const areaId = this.value;
        selectClasse.innerHTML = '<option value="">Selecione a classe</option>';
        selectClasse.disabled = true;
        selectCurso.innerHTML = '<option value="">Selecione o curso</option>';
        selectCurso.disabled = true;

        if (!areaId) return;

        const classesUrl = '{{ route("servidores.formacao.classe", ["area_id" => "REPLACE_ME"]) }}'.replace('REPLACE_ME', areaId);
        fetch(classesUrl)
            .then(res => res.json())
            .then(data => {
                data.forEach(classe => {
                    selectClasse.innerHTML += `<option value="${classe.id}">${classe.classe}</option>`;
                });
                selectClasse.disabled = false;
            })
            .catch(console.error);
    });

    selectClasse.addEventListener('change', function () {
        const classeId = this.value;
        selectCurso.innerHTML = '<option value="">Selecione o curso</option>';
        selectCurso.disabled = true;

        if (!classeId) return;

        const cursosUrl = '{{ route("servidores.formacao.curso", ["classe_id" => "REPLACE_ME"]) }}'.replace('REPLACE_ME', classeId);
        fetch(cursosUrl)
            .then(res => res.json())
            .then(data => {
                data.forEach(curso => {
                    selectCurso.innerHTML += `<option value="${curso.id}">${curso.curso}</option>`;
                });
                selectCurso.disabled = false;
            })
            .catch(console.error);
    });
});
</script>
@endsection
