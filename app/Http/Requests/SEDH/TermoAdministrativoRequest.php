<?php

namespace App\Http\Requests\SEDH;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TermoAdministrativoRequest extends FormRequest
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
            'inscr_cpf_cadastrador.required' => 'O campo CPF é obrigatório.',
            'inscr_cpf_cadastrador.min' => 'O campo CPF deve ter pelo menos 14 caracteres.',
            'inscr_cpf_cadastrador.max' => 'O campo CPF deve ter no máximo 14 caracteres.',

            'num_proximo.required' => 'O campo número do processo é obrigatório.',
            'num_proximo.min' => 'O campo número do processo deve ter pelo menos 3 caracteres.',
            'num_proximo.max' => 'O campo número do processo deve ter no máximo 3 caracteres.',

            'num_processo.required' => 'O campo número do processo é obrigatório.',
            'num_processo.min' => 'O campo número do processo deve ter pelo menos 8 caracteres.',
            'num_processo.max' => 'O campo número do processo deve ter no máximo 8 caracteres.',

            'dt_documento.required' => 'O campo data do documento é obrigatório.',
            'dt_documento.min' => 'O campo data do documento deve ter pelo menos 4 caracteres.',
            'dt_documento.max' => 'O campo data do documento deve ter no máximo 4 caracteres.',

            'dt_inicio.required' => 'O campo data de início é obrigatório.',
            'dt_inicio.min' => 'O campo data de início deve ter pelo menos 10 caracteres.',
            'dt_inicio.max' => 'O campo data de início deve ter no máximo 10 caracteres.',

            'dt_termino.required' => 'O campo data término é obrigatório.',
            'dt_termino.min' => 'O campo data término deve ter pelo menos 10 caracteres.',
            'dt_termino.max' => 'O campo data término deve ter no máximo 10 caracteres.',
            
            'cod_tipo_termo_adm.required' => 'O campo tipo de termo adminstrativo é obrigatório.',
            
            'cod_situacao.required' => 'O campo código da situação é obrigatório.',

            'secretaria.required' => 'O campo secretaria é obrigatório.',


            'empresa.required' => 'O campo nome da empresa é obrigatório.',
            'empresa.max' => 'O campo nome da empresa deve ter no máximo 50 caracteres.',

            'objeto.required' => 'O campo número do objeto é obrigatório.',
            'objeto.max' => 'O campo número do objeto deve ter no máximo 80 caracteres.',

            'valor.required' => 'O campo valor é obrigatório.',
            'valor.min' => 'O campo valor deve ter pelo menos 1 caracteres.',
            'valor.max' => 'O campo valor deve ter no máximo 18 caracteres.',

            'tipo_valor.required' => 'O campo tipo valor é obrigatório.',

            'dt_termino.required' => 'O campo data término é obrigatório.',
            'dt_termino.min' => 'O campo data término deve ter pelo menos 10 caracteres.',
            'dt_termino.max' => 'O campo data término deve ter no máximo 10 caracteres.',

            'livro.required' => 'O campo livro é obrigatório.',
            'livro.max' => 'O campo livro deve ter no máximo 4 caracteres.',

            'folha.required' => 'O campo folha é obrigatório.',
            'folha.max' => 'O campo folha deve ter no máximo 6 caracteres.',

        ];
    }

    public function rules()
    {

        //$teste = Request::get('cod_tipo_termo_adm');
        //dd($teste);

        return [

            'inscr_cpf_cadastrador' => 'required|string|min:14|max:14',
            'cod_tipo_termo_adm' => 'required|integer',
            'cod_tipo_servico' => 'required|integer',
            'cod_situacao' => 'required|integer',
            'secretaria' => 'required|string|max:30',

            'num_proximo' => 'required|string|min:3|max:3',
            'num_processo' => 'required|string|min:8|max:8',

            'dt_documento' => 'required:string|min:4|max:4',
            'dt_inicio' => 'required:string|min:10|max:10',
            'dt_termino' => 'required:string|min:10|max:10',

            'empresa' => 'required|string|max:50',
            'objeto' => 'required|string|max:80',
            'valor' => 'required|string|min:1|max:18',
            'tipo_valor' => 'required|string',

            'livro' => 'nullable:string|max:4',
            'folha' => 'nullable:string|max:6',

        ];
    }

}
