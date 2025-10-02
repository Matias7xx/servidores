<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDependenteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'sexo_dependente' => 'required',
            'tipo_dependente' => 'required|in:Cônjuge,Filho(a),Pai,Mãe',
            'data_nascimento' => 'required',
            'cpf' => 'required|string|size:11',
            'anexo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'nome.string' => 'O nome deve ser um texto válido.',
            'nome.max' => 'O nome não pode ter mais de 255 caracteres.',

            'sexo_dependente.required' => 'O sexo é obrigatório.',
            'tipo_dependente.required' => 'O tipo de parentesco é obrigatório.',
            'tipo_dependente.in' => 'O tipo de parentesco deve ser: Cônjuge, Filho(a), Pai ou Mãe.',

            'data_nascimento.required' => 'A data de nascimento é obrigatória.',

            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.string' => 'O CPF deve ser um texto válido.',
            'cpf.size' => 'O CPF deve ter exatamente 11 dígitos.',

            'anexo.file' => 'O anexo deve ser um arquivo válido.',
            'anexo.mimes' => 'O anexo deve ser um arquivo PDF, JPG, JPEG ou PNG.',
            'anexo.max' => 'O anexo não pode ser maior que 2MB.',
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nome' => 'nome',
            'sexo_dependente' => 'sexo',
            'tipo_dependente' => 'tipo de parentesco',
            'data_nascimento' => 'data de nascimento',
            'cpf' => 'CPF',
            'anexo' => 'anexo',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('cpf')) {
            $this->merge([
                'cpf' => preg_replace('/[^0-9]/', '', $this->cpf),
            ]);
        }

        if ($this->has('nome')) {
            $this->merge([
                'nome' => trim($this->nome),
            ]);
        }

        if ($this->has('data_nascimento')) {
            $this->merge([
                'data_nascimento' => trim($this->data_nascimento),
            ]);
        }

        if ($this->has('sexo_dependente')) {
            $sexo = strtolower($this->sexo_dependente);
            $this->merge([
                'sexo_dependente' => $sexo === 'masculino' ? 'Masculino' : ($sexo === 'feminino' ? 'Feminino' : $this->sexo_dependente),
            ]);
        }

        if ($this->has('tipo_dependente')) {
            $tipos = [
                'conjuge' => 'Cônjuge',
                'filho' => 'Filho(a)',
                'filha' => 'Filho(a)',
                'pai' => 'Pai',
                'mae' => 'Mãe'
            ];

            $tipo = strtolower(preg_replace('/[^a-zA-Z]/', '', $this->tipo_dependente));
            $this->merge([
                'tipo_dependente' => $tipos[$tipo] ?? $this->tipo_dependente,
            ]);
        }
    }
}
