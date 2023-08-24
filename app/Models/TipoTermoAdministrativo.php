<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TipoTermoAdministrativo extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'tipo_termos_administrativos';

	protected $primaryKey = 'cod_tipo_termo_adm';

    protected $fillable = [
        'cod_ato_adm',
        'desc_resumida_ato_adm',
		'desc_detalhada_ato_adm',
        'uniqid',
		'created_at',
		'updated_at'
	];

    public function TermoAdministrativo()
    {
        return $this->hasMany('App\Models\TermoAdministrativo');
    }
}