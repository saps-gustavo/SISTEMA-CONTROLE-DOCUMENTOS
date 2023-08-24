<?php

namespace App\Http\Requests\SEDH;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Request;


class TermoAdministrativoAditivoRequest extends FormRequest
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


            'num_aditivo.required' => 'O campo número do aditivo é obrigatório.',

             'observacao.required' => 'O campo observação é obrigatório.',
             'observacao.max' => 'O campo observação deve ter no máximo 30 caracteres.',
  
             'dt_inicio_aditivo.required' => 'O campo data de início do aditivo é obrigatório.',
             'dt_inicio_aditivo.min' => 'O campo data de início do aditivo deve ter pelo menos 10 caracteres.',
             'dt_inicio_aditivo.max' => 'O campo data de início do aditivo deve ter no máximo 10 caracteres.',
 
             'dt_termino_aditivo.required' => 'O campo data término do aditivo é obrigatório.',
             'dt_termino_aditivo.min' => 'O campo data término do aditivo deve ter pelo menos 10 caracteres.',
             'dt_termino_aditivo.max' => 'O campo data término do aditivo deve ter no máximo 10 caracteres.',
             
             'vlr_reajuste.required' => 'O campo valor é obrigatório.',
             'vlr_reajuste.min' => 'O campo valor deve ter pelo menos 1 caracteres.',
             'vlr_reajuste.max' => 'O campo valor deve ter no máximo 18 caracteres.',
 
             'objeto.required' => 'O campo número do objeto é obrigatório.',
             'objeto.max' => 'O campo número do objeto deve ter no máximo 80 caracteres.',
 
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
 
             'num_aditivo' => 'required|string|min:2|max:3',
             
             'observacao' => 'required|string|max:30',
 
             'dt_inicio_aditivo' => 'required:string|min:10|max:10',
             'dt_termino_aditivo' => 'required:string|min:10|max:10',
 
             'vlr_reajuste' => 'required|string|min:1|max:18',

             'objeto' => 'required|string|max:80',
 
             'livro' => 'nullable:string|max:4',
             'folha' => 'nullable:string|max:6',
 
         ];
     }
}
