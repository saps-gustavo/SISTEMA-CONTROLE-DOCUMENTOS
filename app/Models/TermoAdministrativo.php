<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class TermoAdministrativo extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'cadastro_termos_administrativos';

	protected $primaryKey = 'id_termo_adm';

    protected $fillable = [
        'cod_tipo_termo_adm',
        'dt_documento',
        'num_proximo',
        'cod_tipo_servico',
        'cod_situacao',
        'secretaria',
        'empresa',
		'objeto',
        'num_processo',
        'valor',
        'tipo_valor',
        'dt_inicio',
        'dt_termino',
        'livro',
        'folha',
        'encerrado',
        'inscr_cpf_cadastrador',
        'uniqid',
		'created_at',
		'updated_at'
	];

      /*protected function setKeysForSaveQuery(Builder $query)
        {
            parent::setKeysForSaveQuery($query);
            $query->where('cod_tipo_ato_adm', '=', $this->cod_tipo_ato_adm)
                  ->where('data', '=', $this->data);
            return $query;
        } */

    public function TipoTermoAdministrativo() {
        return $this->belongsTo('App\Models\TipoTermoAdministrativo', 'cod_tipo_termo_adm', 'cod_tipo_termo_adm');
    }

    //Relação entre a tabela termo administrativo com tipo de serviço. Um mesmo termo vai ter um tipo de serviço ou vários. 

    public function TipoServico()
    {
        return $this->belongsTo('App\TipoServico', 'cod_tipo_servico', 'cod_tipo_servico');
    }

    //Relação entre a tabela termo administrativo com situação termo administrativo. Um mesmo termo vai ter um tipo de serviço ou vários. 

    
    public function SituacaoTermoAdministrativo()
    {
        return $this->belongsTo('App\SituacaoTermoAdministrativo', 'cod_situacao', 'cod_situacao');
    }

    public function TermoAdministrativoAditivo()
    {
        return $this->hasMany('App\TermoAdministrativoAditivo', 'id_termo_adm_aditivo', 'id_termo_adm_aditivo');
    }
    //
}
