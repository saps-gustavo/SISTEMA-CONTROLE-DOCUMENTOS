<?php

namespace App\Http\Requests\SEDH;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Request;



class TipoServicoRequest extends FormRequest
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


            'desc_tipo_servico.required' => 'O campo descrição detalhada é obrigatório.',
            'desc_tipo_servico.max' => 'O campo descrição detalhada deve ter no máximo 50 caracteres.',
        ];
    }

    public function rules()
    {
        return [
     
            'desc_tipo_servico' => 'required|string|max:50'
        ];
    }
}
