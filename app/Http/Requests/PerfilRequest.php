<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PerfilRequest extends FormRequest
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

    public function messages()
    {
        return
        [
            'name.required' => 'O campo Nome é obrigatório',
            'name.string' => 'Formato Inválido no campo Nome',
            'name.max' => 'Limite de caracteres excedido no campo Nome, máximo 150.',
            'title.string' => 'Formato Inválido no campo Título',
            'title.max' => 'Limite de caracteres excedido no campo Título, máximo 150.'
        ];
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:150',
            'title' => 'nullable:string|max:255'
        ];
    }}
