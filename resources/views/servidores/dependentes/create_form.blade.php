<input type="hidden" name="id" value="{{ auth()->user()->id }}">
<input type="hidden" name="matricula" value="{{ auth()->user()->matricula }}">

<div class="grid gap-6 md:grid-cols-3 mb-3">
    <div class="col-span-2 flex items-center">
        <h2 class="text-2xl font-semibold text-gray-700">
            Cadastro
        </h2>
    </div>
</div>

<div class="overflow-x-auto border border-gray-300 rounded-lg">
    <div class="bg-black text-white p-2 rounded-lg border-l-8" style="border-left-color: rgb(193,168,90);">
        <h2 class="text-xl font-semibold">
            Dependentes
        </h2>
    </div>
    <div class="p-3">
        <div class="grid gap-6 md:grid-cols-2">
            <div class="col-span-1">
                <label class="label dark:text-gray-700">Nome</label>
                <input type="text" name="nome" value="{{ old('nome') }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 {{ $errors->has('nome') ? 'border-red-500' : '' }}" />
                @error('nome')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1">
                <label class="label dark:text-gray-700">Sexo</label>
                <select name="sexo_dependente"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 {{ $errors->has('sexo_dependente') ? 'border-red-500' : '' }}">
                    <option>{{ old('sexo_dependente') }}</option>
                    <option>Masculino</option>
                    <option>Feminino</option>
                </select>
                @error('sexo_dependente')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="col-span-1">
                <label class="label dark:text-gray-700">Tipo parentesco</label>
                <select name="tipo_dependente"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 {{ $errors->has('tipo_dependente') ? 'border-red-500' : '' }}">
                    <option>{{ old('tipo_dependente') }}</option>
                    <option>Conjuge</option>
                    <option>Filho(a)</option>
                    <option>Afilhado(a)</option>
                    <option>Pai</option>
                    <option>Mãe</option>
                </select>
                @error('tipo_dependente')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1">
                <label class="label dark:text-gray-700">Data Nascimento</label>
                <input type="date" name="datanascimento" value="{{ old('datanascimento') }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 {{ $errors->has('datanascimento') ? 'border-red-500' : '' }}" />
                @error('datanascimento')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="col-span-1">
                <label class="label dark:text-gray-700">Cpf</label>
                <input type="text" name="cpf" value="{{ old('cpf') }}" maxlength="11"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 {{ $errors->has('cpf') ? 'border-red-500' : '' }}" />
                @error('cpf')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1">
                <label class="label dark:text-gray-700">Anexo <font color="red">(.pdf)</font></label>
                <input type="file" name="anexo" accept=".pdf"
                    class="file-input file-input-bordered w-full h-8 dark:text-black {{ $errors->has('anexo') ? 'border-red-500' : '' }}" />
                @error('anexo')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Botões -->
        <div class="flex justify-end space-x-4 mt-6">
            <button type="submit" class="inline-flex items-center gap-1 bg-green-600 text-white text-sm font-semibold rounded-full px-4 py-1 hover:bg-green-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Cadastrar novo dependente
            </button>
            <a href="{{ route('servidores.servidor_dependentes_lista') }}" class="inline-flex items-center gap-1 bg-gray-600 text-white text-sm font-semibold rounded-full px-4 py-1 hover:bg-gray-700 transition"><svg
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                </svg>
                Voltar para a lista</a>
        </div>
    </div>
</div>
