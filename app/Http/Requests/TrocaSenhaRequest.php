<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrocaSenhaRequest extends FormRequest
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
            'password_new.min' => 'A senha deve ter no mínimo 6 caracteres',
            'password_new.required' => 'O campo Senha Nova é obrigatório',
            'password_new.string' => 'Formato inválido no campo Senha Nova',
            'password_old.min' => 'A senha deve ter no mínimo 6 caracteres',
            'password_old.required' => 'O campo Senha Antiga é obrigatório',
            'password_old.string' => 'Formato inválido no campo Senha Nova',
            'password_new.confirmed' => 'A senha e a confirmação de senha devem ser idênticas'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_hidden' => 'required|integer',
            'password_new' => 'required|string|min:6|confirmed',
            'password_old' => 'required|string|min:6'
        ];
    }
}
