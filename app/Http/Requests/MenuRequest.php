<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
    

    public function rules()
    {
        return [
            'label_menu' => 'required:string|max:150',
            'url_menu' => 'nullable:string|max:150',
            'icone_menu' => 'nullable:string|max:100',
            'classe_menu' => 'nullable:string|max:255',
            'target_menu' => 'nullable:string|max:20',
            'id_funcionalidade' => 'nullable:integer'
        ];
    }
}
