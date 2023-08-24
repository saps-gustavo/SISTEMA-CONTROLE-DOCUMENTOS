<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParametrosConfigSoftware extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'tb_parametros_config_software';

	protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'flag',
        'qtd_limite_dias_senha',
        'qtd_limite_acessos_senha',
		'dt_hr_ultima_config',
        'inscr_cpf_administrador',
        'ano_corrente'
	];
    
}
