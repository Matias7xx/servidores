<h2 class="mt-8 text-2xl font-semibold text-gray-700 mb-6">
    Cadastrar novo bairro
</h2>
<div class="grid gap-6 md:grid-cols-2 relative">
    <div class="container box">
        <div class="form-group relative">
            <label class="label">
                <span class="label-text font-bold">Nome da Cidade</span>
            </label>
            <input type="text" name="country_name" id="country_name"
                   class="input input-bordered w-full dark:text-black"
                   placeholder="Digite o nome da cidade" autocomplete="off" />
            <!-- Dropdown -->
            <div id="countryList"
                 class="absolute z-50 w-full bg-white border border-gray-300 rounded-lg shadow-lg hidden dark:bg-gray-800 dark:border-gray-600">
                <!-- Sugestões vão aqui -->
            </div>
        </div>
        {{ csrf_field() }}
    </div>
    <div>
        <label class="label">
            <span class="label-text font-bold">Nome do Bairro</span>
        </label>
        <input type="text" name="nome" value="{{ old('nome') }}" placeholder="Digite o nome"
               class="input input-bordered w-full dark:text-black" />
        @error('nome')
            <span class="text-error text-sm">{{ $message }}</span>
        @enderror
    </div>
</div>

<!-- Botões -->
<div class="flex justify-end space-x-4 mt-6">
    <button type="submit" class="btn btn-success">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        Cadastrar
    </button>
    <button type="submit" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
        </svg>
        Ir para a lista
    </button>
</div>
