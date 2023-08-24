<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class vwTermoAdministrativoAditivo extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'vw_termo_adm_aditivo';

    protected $primaryKey = null;

    public $incrementing = false;

    protected $fillable = [
        'id_termo_adm_aditivo',
        'cod_tipo_termo_adm',
        'cod_ato_adm',
        'dt_documento',
        'num_proximo',
        'num_aditivo',
        'desc_resumida_ato_adm',
        'uniqid',
		'created_at',
		'updated_at'
	];

}