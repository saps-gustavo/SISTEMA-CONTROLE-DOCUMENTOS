<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;


class TermoAdministrativoAditivo extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'termo_adm_aditivo';

	protected $primaryKey = 'id_termo_adm_aditivo';

    protected $fillable = [

        'num_aditivo',
        'id_termo_adm',
        'observacao',
        'dt_inicio_aditivo',
        'dt_termino_aditivo',
        'vlr_reajuste',
        'objeto',
        'livro',
        'folha',
        'uniqid',
		'created_at',
		'updated_at'
	];


    public function TermoAdministrativo() {
        return $this->belongsTo('App\Models\TermoAdministrativo', 'id_termo_adm', 'id_termo_adm');
    }


    /*public function TipoTermoAdministrativo() {
        return $this->belongsTo('App\Models\TermoAdministrativo', 'cod_tipo_termo_adm', 'cod_tipo_termo_adm');
    } */


      /*protected function setKeysForSaveQuery(Builder $query)
        {
            parent::setKeysForSaveQuery($query);
            $query->where('cod_tipo_ato_adm', '=', $this->cod_tipo_ato_adm)
                  ->where('data', '=', $this->data)
                  ->where('num_proximo', '=', $this->num_proximo);
            return $query;
        } */

}
