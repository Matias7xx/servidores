<input type="hidden" name="matricula" value="{{ auth()->guard('web')->user()->matricula }}">
<input type="hidden" name="servidor_id" value="{{ auth()->guard('web')->user()->servidor_id }}">

<div class="grid gap-6 md:grid-cols-3 mb-3">
    <div class="col-span-2 flex items-center">
        <h2 class="text-2xl font-semibold text-gray-700">
            Cadastrar
        </h2>
    </div>
</div>

<div class="overflow-x-auto border border-gray-300 rounded-lg">
    <div class="bg-black text-white p-2 rounded-lg border-l-8" style="border-left-color: rgb(193,168,90);">
        <h2 class="text-xl font-semibold">
            Formação acadêmica
        </h2>
    </div>
    <div class="p-3">

        <div class="grid gap-6 md:grid-cols-2">
            <div class="col-span-1">
                <label class="label dark:text-gray-700">Área</label>
                <select name="area_id" class="w-full border border-gray-300 rounded-lg p-1">
                </select>
                @error('area_id')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-1">
                <label class="label dark:text-gray-700">Classe</label>
                <select name="classe_id" class="w-full border-gray-300 rounded-lg p-1">
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
                </select>
                @error('curso_id')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1">
                <label class="label dark:text-gray-700">Observação</label>
                <input type="text" name="obs" class="w-full border-gray-300 rounded-lg p-1" />
                @error('obs')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            <div class="col-span-1">
                <label class="label dark:text-gray-700">Data Conclusão</label>
                <input type="date" name="dataconclusao" class="w-full border-gray-300 rounded-lg p-1" />
                @error('dataconclusao')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1">
                <label class="label dark:text-black">
                    <font color="red">Substituir <font color="black">Certificado frente <font color="red">(.pdf)
                            </font>
                        </font>
                    </font>
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
                    <font color="red">Substituir <font color="black">Certificado verso <font color="red">(.pdf)
                            </font>
                        </font>
                    </font>
                </label>
                <input type="file" name="anexo_verso"
                    class="file-input file-input-bordered w-full h-8 dark:text-black {{ $errors->has('anexo') ? 'border-red-500' : '' }}"
                    accept=".pdf" />
                @error('anexo_verso')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Botões -->
        <div class="flex justify-end space-x-4 mt-6">
            <button type="submit"
                class="inline-flex items-center gap-1 bg-green-600 text-white text-sm font-semibold rounded-full px-4 py-1 hover:bg-green-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M17 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V7l-4-4zm3 16H4V5h13v3h3v11z M8 15h8M8 11h8" />
                </svg>
                Cadastrar</button>
            <a href="{{ route('servidores.formacao.list') }}"
                class="inline-flex items-center gap-1 bg-gray-600 text-white text-sm font-semibold rounded-full px-4 py-1 hover:bg-gray-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                </svg>
                Voltar para a lista</a>
        </div>

    </div>
</div>

{{-- Passando os dados para JS --}}
<script>
    const areas = @json($formacao_area);
    const classes = @json($formacao_classe);
    const cursos = @json($formacao_curso);

    const selectArea = document.querySelector('select[name="area_id"]');
    const selectClasse = document.querySelector('select[name="classe_id"]');
    const selectCurso = document.querySelector('select[name="curso_id"]');

    function limparSelect(select) {
        select.innerHTML = '';
        const optionDefault = document.createElement('option');
        optionDefault.value = '';
        if (select === selectArea) optionDefault.text = 'Selecione a área';
        else if (select === selectClasse) optionDefault.text = 'Selecione a classe';
        else if (select === selectCurso) optionDefault.text = 'Selecione o curso';
        select.appendChild(optionDefault);
    }

    function popularAreas() {
        limparSelect(selectArea);
        areas.forEach(area => {
            const option = document.createElement('option');
            option.value = area.id;
            option.textContent = area.area;
            selectArea.appendChild(option);
        });
    }

    function popularClasses(areaId) {
        limparSelect(selectClasse);
        limparSelect(selectCurso);

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
        limparSelect(selectCurso);

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
        limparSelect(selectCurso);
    });

    selectClasse.addEventListener('change', function () {
        popularCursos(this.value);
    });

    // Popula área ao carregar
    popularAreas();
</script>