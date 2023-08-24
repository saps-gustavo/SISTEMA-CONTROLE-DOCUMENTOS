<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class vwTermoAdministrativo extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'vw_termo_adm';

    protected $primaryKey = null;

    public $incrementing = false;


    protected $fillable = [
        'id_termo_adm',
        'cod_tipo_termo_adm',
        'cod_ato_adm',
        'dt_documento',
        'num_proximo',
        'quantidade_aditivos',
        'desc_resumida_ato_adm',
        'uniqid',
		'created_at',
		'updated_at'
	];
}
