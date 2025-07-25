<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServidorRequest extends FormRequest
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
            'cpf' => ['required', 'max:11', 'min:11', 'regex:/^[0-9]+$/'],            
            //'telefone' => 'max:15|min:10',
            //'cidade_id' => 'required',
        ];
    }

    public function messages(){
        return[
            'cpf.required' => 'O campo (Cpf) é obrigatório!',
            'cpf.min' => 'Quantidade minima de 11 (onze) caracteres!',
            'cpf.max' => 'Quantidade máxima de 11 (onze) caracteres!',
            // 'telefone.min' => 'Quantidade minima de 10 (dez) caracteres!',
            // 'telefone.max' => 'Quantidade máxima de 255 (duzentos e cinquenta e cinco) caracteres!',
            // 'cidade_id.required' => 'O campo (Cidade) é obrigatório!',

            // 'codigo.max' => 'Quantidade máxima de 11 (onze) caracteres!',
            // 'tipo_estrutural.required' => 'O campo (Tipo Estrutural) é obrigatório!',
            // 'tipo_estrutural.integer' => 'No campo (Tipo Estrutural) digite apenas números!',
            // 'srpc.required' => 'O campo (Srpc) é obrigatório!',
            // 'srpc.integer' => 'No campo (Srpc) digite apenas números!',
            // 'dspc.required' => 'O campo (Dspc) é obrigatório!',
            // 'dspc.integer' => 'No campo (Dspc) digite apenas números!',
            // 'nivel.required' => 'O campo (Nível) é obrigatório!',
            // 'nivel.integer' => 'No campo (Nível) digite apenas números!',
            // 'sede.required' => 'O campo (Sede) é obrigatório!',
            // 'sede.integer' => 'No campo (Sede) digite apenas números!',
        ];
    }
}
