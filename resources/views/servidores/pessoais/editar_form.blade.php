<input type="hidden" name="id" value="{{ old('id', $servidor->id) }}">
<div class="grid gap-6 md:grid-cols-3 mb-3">
    <div class="col-span-2 flex items-center">
        <h2 class="text-2xl font-semibold text-gray-700">
            Dados Pessoais
            <br><span class="text-sm">Data da próxima atualização: <span
                    class="text-red-500">{{ date('d/m/Y', strtotime($servidor->next_updated)) }}</span></span>
        </h2>
    </div>
</div>

<div class="overflow-x-auto border border-gray-300 rounded-lg">
    <div class="bg-black text-white p-2 rounded-lg border-l-8" style="border-left-color: rgb(193,168,90);">
        <h2 class="text-xl font-semibold">
            Atualizar Dados Pessoais
        </h2>
    </div>
    <div class="p-3">
        <div class="grid gap-6 md:grid-cols-5">
            <div class="col-span-2">
                <label class="label dark:text-black">Nome</label>
                <input type="text" name="nome" value="{{ old('nome', $servidor->nome) }}"
                    class="bg-gray-200 w-full border-gray-300 rounded-lg py-1 px-2 {{ $errors->has('nome') ? 'border-red-500' : '' }}"
                    disabled />
            </div>
            <div class="col-span-2">
                <label class="label dark:text-black">Cargo</label>
                <input type="text" name="cargo" id="cargo"
                    value="{{ old('cargo', $servidor->cargo_nome->nome) }}" disabled
                    class="bg-gray-200 w-full border-gray-300 rounded-lg py-1 px-2" />
            </div>
            <div class="col-span-1">
                <label class="label dark:text-black">Matrícula</label>
                <input type="text" name="matricula" value="{{ old('matricula', $servidor->matricula) }}" disabled
                    class="bg-gray-200 w-full border-gray-300 rounded-lg py-1 px-2" />
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-8">
            <div class="col-span-2">
                <label class="label dark:text-black">Cpf</label>
                <input type="text" disabled name="cpf" value="{{ old('cpf', $servidor->cpf) }}"
                    class="bg-gray-200 w-full border-gray-300 rounded-lg py-1 px-2" />
            </div>

            <div class="col-span-2">
                <label class="label dark:text-black">Sexo</label>
                <input type="text" disabled name="sexo" value="{{ old('sexo', $servidor->sexo) }}"
                    class="bg-gray-200 w-full border-gray-300 rounded-lg py-1 px-2" />
            </div>

            <div class="col-span-2">
                <label class="label dark:text-black">Orientação Sexual</label>
                <select name="orientacao"
                    class="w-full border border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->orientacao == 1) @if (empty($servidor->orientacao)) border-red-500 @else border-green-500 @endif @endif">
                    <option value=""></option>
                    <option value="HE" {{ old('orientacao', $servidor->orientacao) == 'HE' ? 'selected' : '' }}>
                        Heterossexual</option>
                    <option value="HO" {{ old('orientacao', $servidor->orientacao) == 'HO' ? 'selected' : '' }}>
                        Homossexual
                    </option>
                    <option value="BI" {{ old('orientacao', $servidor->orientacao) == 'BI' ? 'selected' : '' }}>
                        Bissexual
                    </option>
                    <option value="OU" {{ old('orientacao', $servidor->orientacao) == 'OU' ? 'selected' : '' }}>
                        Outros
                    </option>
                </select>
            </div>

            <div class="col-span-2">
                <label class="label dark:text-black">Data Nascimento</label>
                <input type="date" name="datanascimento"
                    value="{{ old('datanascimento', $servidor->datanascimento) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->datanascimento == 1) @if (empty($servidor->datanascimento)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('datanascimento')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-5">
            <div class="col-span-1">
                <label class="label dark:text-black">Reservista</label>
                <input type="text" name="reservista" value="{{ old('reservista', $servidor->reservista) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->reservista == 1) @if (empty($servidor->reservista)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('reservista')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2">
                <label class="label dark:text-black">Nome do Pai</label>
                <input type="text" name="pai" value="{{ old('pai', $servidor->pai) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->pai == 1) @if (empty($servidor->pai)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('pai')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2">
                <label class="label dark:text-black">Nome da Mãe</label>
                <input type="text" name="mae" value="{{ old('mae', $servidor->mae) }}"
                    class="w-full rounded-lg py-1 px-2 @if ($servidor_config[0]->mae == 1) @if (empty($servidor->mae)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('mae')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-6">
            <div class="col-span-2">
                <label class="label dark:text-black">Número Pasep</label>
                <input type="text" name="pasep" value="{{ old('pasep', $servidor->pasep) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->pasep == 1) @if (empty($servidor->pasep)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('pasep')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2">
                <label class="label dark:text-black">Possui alergia?</label>
                <input type="text" name="alergia" value="{{ old('alergia', $servidor->alergia) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->alergia == 1) @if (empty($servidor->alergia)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('alergia')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2">
                <label class="label dark:text-black">Nacionalidade</label>
                <input type="text" name="nacionalidade"
                    value="{{ old('nacionalidade', $servidor->nacionalidade) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->nacionalidade == 1) @if (empty($servidor->nacionalidade)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('nacionalidade')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-8">
            <div class="col-span-2">
                <label class="label dark:text-black">Religião</label>
                <select name="religiao"
                    class="w-full border border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->religiao == 1) @if (empty($servidor->religiao)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif">
                    <option value=""></option>
                    <option value="CA" {{ old('religiao', $servidor->religiao) == 'CA' ? 'selected' : '' }}>
                        Catolicismo
                    </option>
                    <option value="PR" {{ old('religiao', $servidor->religiao) == 'PR' ? 'selected' : '' }}>
                        Protestantismo
                    </option>
                    <option value="AD" {{ old('religiao', $servidor->religiao) == 'AD' ? 'selected' : '' }}>
                        Adventismo
                    </option>
                    <option value="MO" {{ old('religiao', $servidor->religiao) == 'MO' ? 'selected' : '' }}>
                        Mormonismo
                    </option>
                    <option value="TE" {{ old('religiao', $servidor->religiao) == 'TE' ? 'selected' : '' }}>
                        Testemunhas de
                        Jeová</option>
                    <option value="ES" {{ old('religiao', $servidor->religiao) == 'ES' ? 'selected' : '' }}>
                        Espiritismo
                    </option>
                    <option value="OU" {{ old('religiao', $servidor->religiao) == 'OU' ? 'selected' : '' }}>Outra
                    </option>
                </select>
            </div>

            <div class="col-span-2">
                <label class="label dark:text-black">Naturalidade</label>
                <input type="text" name="naturalidade" value="{{ old('naturalidade', $servidor->naturalidade) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->naturalidade == 1) @if (empty($servidor->naturalidade)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('naturalidade')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2">
                <label class="label dark:text-black">Tipo Sanguíneo</label>
                <select name="tiposanguineo"
                    class="w-full border border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->tiposanguineo == 1) @if (empty($servidor->tiposanguineo)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif">
                    <option value=""></option>
                    <option value="A"
                        {{ old('tiposanguineo', $servidor->tiposanguineo) == 'A' ? 'selected' : '' }}>A
                    </option>
                    <option value="B"
                        {{ old('tiposanguineo', $servidor->tiposanguineo) == 'B' ? 'selected' : '' }}>B
                    </option>
                    <option value="AB"
                        {{ old('tiposanguineo', $servidor->tiposanguineo) == 'AB' ? 'selected' : '' }}>AB
                    </option>
                    <option value="O"
                        {{ old('tiposanguineo', $servidor->tiposanguineo) == 'O' ? 'selected' : '' }}>O
                    </option>
                </select>
                @error('tiposanguineo')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-2">
                <label class="label dark:text-black">Fator RH</label>
                <select name="fator_rh"
                    class="w-full border border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->fator_rh == 1) @if (empty($servidor->fator_rh)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif">
                    <option value=""></option>
                    <option value="Positivo"
                        {{ old('fator_rh', $servidor->fator_rh) == 'Positivo' ? 'selected' : '' }}>
                        Positivo</option>
                    <option value="Negativo"
                        {{ old('fator_rh', $servidor->fator_rh) == 'Negativo' ? 'selected' : '' }}>
                        Negativo</option>
                </select>
                @error('fator_rh')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-6">
        </div>

        <div class="grid gap-6 md:grid-cols-5">
            <div class="col-span-2">
                <label class="label dark:text-black">Título de Eleitor</label>
                <input type="text" name="titulonumero" value="{{ old('titulonumero', $servidor->titulonumero) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->titulonumero == 1) @if (empty($servidor->titulonumero)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('titulonumero')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-1">
                <label class="label dark:text-black">Zona</label>
                <input type="text" name="titulozona" value="{{ old('titulozona', $servidor->titulozona) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->titulozona == 1) @if (empty($servidor->titulozona)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('titulozona')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-1">
                <label class="label dark:text-black">Sessão</label>
                <input type="text" name="titulosecao" value="{{ old('titulosecao', $servidor->titulosecao) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->titulosecao == 1) @if (empty($servidor->titulosecao)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('titulosecao')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1">
                <label class="label dark:text-black">Colete balístico</label>
                <select name="tamanho_colete"
                    class="w-full border border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->tamanho_colete == 1) @if (empty($servidor->tamanho_colete)) border-red-500 @else border-green-500 @endif @endif">
                    <option value="{{ old('tamanho_colete', $servidor->tamanho_colete) }}">
                        {{ old('tamanho_colete', $servidor->tamanho_colete) }}</option>
                    <option>P</option>
                    <option>M</option>
                    <option>G</option>
                    <option>EG</option>
                </select>
                @error('tamanho_colete')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-4">
            <div class="col-span-1">
                <label class="label dark:text-black">Número CNH</label>
                <input type="text" name="numerocnh" value="{{ old('numerocnh', $servidor->numerocnh) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->numerocnh == 1) @if (empty($servidor->numerocnh)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('numerocnh')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-1">
                <label class="label dark:text-black">Categoria</label>
                <input type="text" name="categoriacnh" value="{{ old('categoriacnh', $servidor->categoriacnh) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->categoriacnh == 1) @if (empty($servidor->categoriacnh)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('categoriacnh')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-1">
                <label class="label dark:text-black">Escolaridade</label>
                <select name="grauinstrucao"
                    class="w-full border border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->grauinstrucao == 1) @if (empty($servidor->grauinstrucao)) border-red-500 @else border-green-500 @endif @endif">
                    <option value=""></option>
                    <option value="SC"
                        {{ old('grauinstrucao', $servidor->grauinstrucao) == 'SC' ? 'selected' : '' }}>Superior
                        Completo</option>
                    <option value="SI"
                        {{ old('grauinstrucao', $servidor->grauinstrucao) == 'SI' ? 'selected' : '' }}>Superior
                        Incompleto</option>
                    <option value="MC"
                        {{ old('grauinstrucao', $servidor->grauinstrucao) == 'MC' ? 'selected' : '' }}>Médio Completo
                    </option>
                    <option value="MI"
                        {{ old('grauinstrucao', $servidor->grauinstrucao) == 'MI' ? 'selected' : '' }}>Médio Incompleto
                    </option>
                    <option value="FU"
                        {{ old('grauinstrucao', $servidor->grauinstrucao) == 'FU' ? 'selected' : '' }}>Fundamental
                        Completo</option>
                    <option value="ME"
                        {{ old('grauinstrucao', $servidor->grauinstrucao) == 'ME' ? 'selected' : '' }}>Mestrado
                    </option>
                    <option value="DO"
                        {{ old('grauinstrucao', $servidor->grauinstrucao) == 'DO' ? 'selected' : '' }}>Doutorado
                    </option>
                    <option value="ES"
                        {{ old('grauinstrucao', $servidor->grauinstrucao) == 'ES' ? 'selected' : '' }}>Especialista
                    </option>
                </select>
                @error('grauinstrucao')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-1">
                <label class="label dark:text-black">Tamanho camisa</label>
                <select name="tamanhocamisa"
                    class="w-full border border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->tamanhocamisa == 1) @if (empty($servidor->tamanhocamisa)) border-red-500 @else border-green-500 @endif @endif">
                    <option value="{{ old('tamanhocamisa', $servidor->tamanhocamisa) }}">
                        {{ old('tamanhocamisa', $servidor->tamanhocamisa) }}</option>
                    <option>P</option>
                    <option>M</option>
                    <option>G</option>
                    <option>GG</option>
                </select>
                @error('tamanhocamisa')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-5">
            <div class="col-span-1">
                <label class="label dark:text-black">Cor/Raça(Ibge)</label>
                <input type="text" name="cor_raca" value="{{ old('cor_raca', $servidor->cor_raca) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->cor_raca == 1) @if (empty($servidor->cor_raca)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('cor_raca')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1">
                <label class="label dark:text-black">Telefone 1</label>
                <input type="text" name="telefone_1" value="{{ old('telefone_1', $servidor->telefone_1) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->telefone_1 == 1) @if (empty($servidor->telefone_1)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('telefone_1')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1">
                <label class="label dark:text-black">Telefone 2</label>
                <input type="text" name="telefone_2" value="{{ old('telefone_2', $servidor->telefone_2) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->telefone_2 == 1) @if (empty($servidor->telefone_2)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('telefone_2')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-2">
                <label class="label dark:text-black">Email</label>
                <input type="text" name="email" value="{{ old('nome', $servidor->email) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->email == 1) @if (empty($servidor->email)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('email')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-6">
            <div class="col-span-1">
                <label class="label dark:text-black">Cep</label>
                <input type="text" name="cep" value="{{ old('cep', $servidor->cep) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->cep == 1) @if (empty($servidor->cep)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('cep')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-1">
                <label class="label dark:text-black">Uf</label>
                <select name="estado"
                    class="w-full border border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->estado == 1) @if (empty($servidor->estado)) border-red-500 @else border-green-500 @endif @endif">
                    <option value="{{ old('nome', $servidor->estado) }}">{{ $servidor->estado }}</option>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->codigo }}">
                            {{ $estado->sigla }}
                        </option>
                    @endforeach
                </select>
                @error('estado')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2">
                <label class="label dark:text-black">Cidade</label>
                <select name="cidade_id" id="cidade"
                    class="w-full border border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->cidade_id == 1) @if (empty($servidor->cidade_id)) border-red-500 @else border-green-500 @endif @endif">
                    <option value="{{ old('nome', $servidor->cidade) }}">{{ $servidor->cidade_nome->nome }}</option>
                    @foreach ($cidades as $cidade)
                        <option value="{{ $cidade->id }}">
                            {{ $cidade->nome }}
                        </option>
                    @endforeach
                </select>
                @error('cidade_id')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-2">
                <label class="label dark:text-black">Bairro</label>
                <input type="text" name="bairro" value="{{ old('nome', $servidor->bairro) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->bairro == 1) @if (empty($servidor->bairro)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('bairro')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-5">
            <div class="col-span-2">
                <label class="label dark:text-black">Rua</label>
                <input type="text" name="rua" value="{{ old('nome', $servidor->rua) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->rua == 1) @if (empty($servidor->rua)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('rua')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1">
                <label class="label dark:text-black">Nr</label>
                <input type="text" name="numero" value="{{ old('nome', $servidor->numero) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->numero == 1) @if (empty($servidor->numero)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('numero')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-2">
                <label class="label dark:text-black">Complemento</label>
                <input type="text" name="complemento" value="{{ old('nome', $servidor->complemento) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->complemento == 1) @if (empty($servidor->complemento)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('complemento')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-6">
            <div class="col-span-2">
                <label class="label dark:text-black">Estado Civil</label>
                <select name="estadocivil"
                    class="w-full border border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->estadocivil == 1) @if (empty($servidor->estadocivil)) border-red-500 @else border-green-500 @endif @endif">
                    <option value="{{ old('estadocivil', $servidor->estadocivil) }}">
                        @if (old('estadocivil', $servidor->estadocivil) != '')
                            @switch(old('estadocivil', $servidor->estadocivil))
                                @case('C')
                                    Casado(a)
                                @break

                                @case('S')
                                    Solteiro(a)
                                @break

                                @case('D')
                                    Divorciado(a)
                                @break

                                @case('V')
                                    Viúvo(a)
                                @break

                                @case('U')
                                    União Estável
                                @break
                            @endswitch
                        @endif
                    </option>
                    <option value="C">Casado(a)</option>
                    <option value="S">Solteiro(a)</option>
                    <option value="D">Divorciado(a)</option>
                    <option value="V">Viúvo(a)</option>
                    <option value="U">União Estável</option>
                </select>
                @error('estadocivil')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-2">
                <label class="label dark:text-black">Cônjuge</label>
                <input type="text" name="conjuge" value="{{ old('nome', $servidor->conjuge) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->conjuge == 1) @if (empty($servidor->conjuge)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('conjuge')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-2">
                <label class="label dark:text-black">CPF Cônjuge</label>
                <input type="text" name="conjuge_cpf" value="{{ old('nome', $servidor->conjuge_cpf) }}"
                    class="w-full border-gray-300 rounded-lg py-1 px-2 @if ($servidor_config[0]->conjuge_cpf == 1) @if (empty($servidor->conjuge_cpf)) border-red-500 @else border-green-500 @endif
@else
border-gray-300 @endif" />
                @error('conjuge_cpf')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Botões -->
        <div class="flex justify-end space-x-4 mt-6">
            <button type="submit" class="inline-flex items-center gap-1 bg-green-600 text-white text-sm font-semibold rounded-full px-4 py-1 hover:bg-green-700 transition"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                Editar Informações</button>
        </div>
    </div>
</div>
