<?php

namespace App\Http\Requests\SEDH;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Request;

class SituacaoTermoAdmRequest extends FormRequest
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


            'desc_situacao.required' => 'O campo descrição detalhada é obrigatório.',
            'desc_situacao.max' => 'O campo descrição detalhada deve ter no máximo 10 caracteres.',
        ];
    }

    public function rules()
    {
        return [
     
            'desc_situacao' => 'required|string|max:10'
        ];
    }
}
