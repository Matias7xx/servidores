<input type="hidden" name="matricula" value="{{ auth()->user()->matricula }}">
<input type="hidden" name="id" value="{{ $servidorFormacao->id }}">

{{-- {{dd($servidorFormacao->formacaoServidorCurso->formacaoClasse->formacaoArea->id);}} --}}

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

        <div class="grid gap-6 md:grid-cols-2">
            <div class="col-span-1">
                <label class="label dark:text-gray-700">Área</label>
                <select name="area_id" class="w-full border border-gray-300 rounded-lg p-1">
                    @if($servidorFormacao->formacaoServidorCurso->id > 0)
                        <option value="{{ $servidorFormacao->formacaoServidorCurso->formacaoClasse->formacaoArea->id }}">
                            {{ $servidorFormacao->formacaoServidorCurso->formacaoClasse->formacaoArea->area }}
                        </option>
                    @else
                        <option value="">Selecione a área</option>
                    @endif
                </select>
                @error('area_id')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-1">
                <label class="label dark:text-gray-700">Classe</label>
                <select name="classe_id" class="w-full border-gray-300 rounded-lg p-1">
                    @if($servidorFormacao->formacaoServidorCurso->id > 0)
                        <option value="{{ $servidorFormacao->formacaoServidorCurso->formacaoClasse->id }}">
                            {{ $servidorFormacao->formacaoServidorCurso->formacaoClasse->classe }}
                        </option>
                    @endif
                </select>
                @error('classe_id')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="col-span-1">
                <label class="label dark:text-gray-700">Curso</label>
                <select name="curso_id" class="w-full border-gray-300 rounded-lg p-1">
                    @if($servidorFormacao->formacaoServidorCurso->id > 0)
                        <option value="{{ $servidorFormacao->formacaoServidorCurso->id }}">
                            {{ $servidorFormacao->formacaoServidorCurso->curso }}
                        </option>
                    @endif
                </select>
                @error('curso_id')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1">
                <label class="label dark:text-gray-700">Observação</label>
                <input type="text" name="obs" class="w-full border-gray-300 rounded-lg p-1" value="{{$servidorFormacao->obs}}"/>
                @error('obs')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            <div class="col-span-1">
                <label class="label dark:text-gray-700">Data Conclusão</label>
                <input type="date" name="dataconclusao" class="w-full border-gray-300 rounded-lg p-1" value="{{$servidorFormacao->data_conclusao}}"/>
                @error('dataconclusao')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1">
                <label class="label dark:text-black">
                    <font color="red">Substituir <font color="black">Certificado frente <font color="red">(.pdf)</font></font></font>
                </label>
                <input type="file" name="anexo_frente"
                    class="file-input file-input-bordered w-full h-8 dark:text-black {{ $errors->has('anexo') ? 'border-red-500' : '' }}"
                    accept=".pdf" />
                @error('anexo_frente')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1">
                <label class="label dark:text-black">
                    <font color="red">Substituir <font color="black">Certificado verso <font color="red">(.pdf)</font></font></font>
                </label>
                <input type="file" name="anexo_verso"
                    class="file-input file-input-bordered w-full h-8 dark:text-black {{ $errors->has('anexo') ? 'border-red-500' : '' }}"
                    accept=".pdf" />
                @error('anexo_verso')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-4 mt-6">
            <button type="submit"
                class="inline-flex items-center gap-1 bg-green-600 text-white text-sm font-semibold rounded-full px-4 py-1 hover:bg-green-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
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

{{-- Script --}}
<script>
    const areas = @json($areas);
    const classes = @json($classes);
    const cursos = @json($cursos);

    const selectArea = document.querySelector('select[name="area_id"]');
    const selectClasse = document.querySelector('select[name="classe_id"]');
    const selectCurso = document.querySelector('select[name="curso_id"]');

    function limparSelectPreservandoPrimeira(select) {
        const primeiraOpcao = select.options[0];
        select.innerHTML = '';
        select.appendChild(primeiraOpcao);
    }

    function popularAreas() {
        limparSelectPreservandoPrimeira(selectArea);
        areas.forEach(area => {
            const option = document.createElement('option');
            option.value = area.id;
            option.textContent = area.area;
            selectArea.appendChild(option);
        });
    }

    function popularClasses(areaId) {
        limparSelectPreservandoPrimeira(selectClasse);
        limparSelectPreservandoPrimeira(selectCurso);

        if (!areaId) return;

        const filtradas = classes.filter(c => c.area_id == areaId);
        filtradas.forEach(classe => {
            const option = document.createElement('option');
            option.value = classe.id;
            option.textContent = classe.classe;
            selectClasse.appendChild(option);
        });
    }

    function popularCursos(classeId) {
        limparSelectPreservandoPrimeira(selectCurso);

        if (!classeId) return;

        const filtrados = cursos.filter(c => c.classe_id == classeId);
        filtrados.forEach(curso => {
            const option = document.createElement('option');
            option.value = curso.id;
            option.textContent = curso.curso;
            selectCurso.appendChild(option);
        });
    }

    selectArea.addEventListener('change', function () {
        popularClasses(this.value);
    });

    selectClasse.addEventListener('change', function () {
        popularCursos(this.value);
    });

    // Popula a área ao carregar a página
    popularAreas();
</script>
