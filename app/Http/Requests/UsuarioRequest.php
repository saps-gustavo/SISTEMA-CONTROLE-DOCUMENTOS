<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UsuarioRequest extends FormRequest
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

    function messages()
    {
        return 
        [
            'nome_usuario.required' => 'O campo nome é obrigatório',
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'Formato inválido no campo email',
            'email.unique' => 'Já existe esse email na nossa base de dados',
            'password.required_without' => 'O campo senha é obrigatório',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres',
            'password.confirmed' => 'A senha e a confirmação de senha devem ser idênticas',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $condicao_email_unique = Request::get('id_usuario')!=null?','.Request::get('id_usuario').',id_usuario':'';

        return [
            'nome_usuario' => 'required|string|max:255',
            'email' => 'required|unique:usuario,email'.$condicao_email_unique.'|string|email|max:255',
            'password' => 'required_without:id_usuario|nullable|string|min:6|confirmed',
        ];
    }
}
