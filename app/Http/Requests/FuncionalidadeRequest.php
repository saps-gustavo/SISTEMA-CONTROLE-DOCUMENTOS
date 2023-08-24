<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuncionalidadeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function messages()
    {
        return [
            'nome_funcionalidade.required' => 'O campo Nome é obrigatório',
            'nome_funcionalidade.string' => 'Formato Inválido no campo Nome',
            'nome_funcionalidade.max' => 'Limite de caracteres excedido no campo Nome, máximo 150.',
            'desc_funcionalidade.required' => 'O campo Descrição é obrigatório',
            'desc_funcionalidade.string' => 'Formato Inválido no campo Descrição',
            'desc_funcionalidade.max' => 'Limite de caracteres excedido no campo Descrição, máximo 255.',
            'apelido.required' => 'O campo Apelido é obrigatório',
            'apelido.string' => 'Formato Inválido no campo Apelido',
            'apelido.max' => 'Limite de caracteres excedido no campo Apelido, máximo 255.',
            'model.string' => 'Formato Inválido no campo Model',
            'model.max' => 'Limite de caracteres excedido no campo Model, máximo 150.',
        ];
    }

    public function rules()
    {
        return [
            'nome_funcionalidade' => 'required|string|max:150',
            'apelido' => 'required|string|max:150',
            'desc_funcionalidade' => 'required:string|max:255',
            'model' => 'nullable:string|max:150'
        ];
    }
}
