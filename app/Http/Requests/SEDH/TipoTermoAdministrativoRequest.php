<?php

namespace App\Http\Requests\SEDH;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Request;


class TipoTermoAdministrativoRequest extends FormRequest
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


            'cod_ato_adm.required' => 'O campo código do ato administrativo é obrigatório.',

            'desc_resumida_ato_adm.required' => 'O campo descrição resumida é obrigatório.',
            'desc_resumida_ato_adm.max' => 'O campo descrição resumida deve ter no máximo 30 caracteres.',

            'desc_detalhada_ato_adm.required' => 'O campo descrição detalhada é obrigatório.',
            'desc_detalhada_ato_adm.max' => 'O campo descrição detalhada deve ter no máximo 200 caracteres.',
        ];
    }

    public function rules()
    {
        return [
     
            'cod_ato_adm' => 'required|string|min:2|max:3',

            'desc_resumida_ato_adm' => 'required|string|max:30',

            'desc_detalhada_ato_adm' => 'required:string|max:200',
        ];
    }
}
