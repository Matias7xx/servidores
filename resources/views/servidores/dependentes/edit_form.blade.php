<input type="hidden" name="id" value="{{ $servidorDependente->id }}">
<input type="hidden" name="matricula" value="{{ auth()->user()->matricula, }}">

<h2 class="mt-8 text-2xl font-semibold text-gray-700 mb-6">
    Editar cadastro de dependente
</h2>
<hr class="my-2">
<div class="grid gap-6 md:grid-cols-7">
    <div class="col-span-3">
        <label class="label dark:text-black">Nome</label>
        <input type="text" name="nome" value="{{ $servidorDependente->nome }}"
            class="input input-bordered w-full dark:text-black {{ $errors->has('nome') ? 'border-red-500' : '' }}" />
        @error('nome')
            <span class="text-error text-sm">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-span-2">
        <label class="label dark:text-black">Sexo</label>
        <select name="sexo_dependente" class="select select-bordered w-full dark:text-black {{ $errors->has('sexo_dependente') ? 'border-red-500' : '' }}">
            <option value="{{ $servidorDependente->sexo_dependente }}">{{ $servidorDependente->sexo_dependente == 'F' ? 'Feminino' : 'Masculino' }}</option>
            <option>Masculino</option>
            <option>Feminino</option>
        </select>
        @error('sexo_dependente')
            <span class="text-error text-sm">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-span-2">
        <label class="label dark:text-black">Tipo parentesco</label>
        <select name="tipo_dependente" class="select select-bordered w-full dark:text-black {{ $errors->has('tipo_dependente') ? 'border-red-500' : '' }}">
            <option value="{{ $servidorDependente->tipo_dependente }}">{{ $servidorDependente->tipo_dependente }}</option>
            <option>Cônjuge</option>
            <option>Filho(a)</option>
            <option>Pai</option>
            <option>Mãe</option>
        </select>
        @error('tipo_dependente')
            <span class="text-error text-sm">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="grid gap-6 md:grid-cols-6">
    <div class="col-span-2">
        <label class="label dark:text-black">Data Nascimento</label>
        <input type="date" name="datanascimento" value="{{ $servidorDependente->data_nascimento }}"
            class="input input-bordered w-full dark:text-black {{ $errors->has('datanascimento') ? 'border-red-500' : '' }}" />
        @error('datanascimento')
            <span class="text-error text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-2">
        <label class="label dark:text-black">Cpf</label>
        <input type="text" name="cpf" value="{{ $servidorDependente->cpf }}" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
            class="input input-bordered w-full dark:text-black {{ $errors->has('cpf') ? 'border-red-500' : '' }}" />
        @error('cpf')
            <span class="text-error text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-2">
        <label class="label dark:text-black">Anexo</label>
        <input type="file" name="documento" class="file-input file-input-bordered w-full dark:text-black {{ $errors->has('documento') ? 'border-red-500' : '' }}" accept=".pdf"/>
        @error('documento')
            <span class="text-error text-sm">{{ $message }}</span>
        @enderror
    </div>
</div>

<!-- Botões -->
<div class="flex justify-end space-x-4 mt-6">
    <button type="submit" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
        Editar cadastro dependente</button>
    <a href="{{ route('servidores.servidor_dependentes_lista', $servidorDependente->servidor_id) }}" class="btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
            </svg>
            Voltar</a>
    
    </div>
