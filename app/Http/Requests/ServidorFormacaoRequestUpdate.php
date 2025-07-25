<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServidorFormacaoRequestUpdate extends FormRequest
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
            'area_id' => 'required',
            'classe_id' => 'required',
            'curso_id' => 'required',
            'dataconclusao' => 'required|date',
            'obs' => 'nullable|string|max:1000',
            // 'anexo_frente' => 'file|mimes:pdf|max:5120', // 5MB
            // 'anexo_verso' => 'file|mimes:pdf|max:5120', // 5MB
        ];
    }

    /**
     * Mensagens personalizadas de erro.
     */
    public function messages(): array
    {
        return [
            'area_id.required' => 'A área é obrigatória.',
            'curso_id.required' => 'O curso é obrigatório.',
            'classe_id.required' => 'A classe é obrigatória.',
            'dataconclusao.required' => 'A data de conclusão é obrigatória.',
            'dataconclusao.date' => 'A data de conclusão deve ser uma data válida.',
            'obs.max' => 'A observação não pode ultrapassar 1000 caracteres.',
            // 'anexo_frente.file' => 'O anexo frente deve ser um arquivo.',
            // 'anexo_frente.mimes' => 'O anexo frente deve ser um arquivo do tipo: pdf.',
            // 'anexo_frente.max' => 'O anexo frente não pode ter mais que 5MB.',
            // 'anexo_verso.file' => 'O anexo verso deve ser um arquivo.',
            // 'anexo_verso.mimes' => 'O anexo verso deve ser um arquivo do tipo: pdf.',
            // 'anexo_verso.max' => 'O anexo não verso pode ter mais que 5MB.',
            // 'anexo_verso.required' => 'O anexo verso é obrigatória.',
        ];
    }
}