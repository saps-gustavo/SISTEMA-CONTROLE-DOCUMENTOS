<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogAtividades extends Model
{
    protected $table = 'log_atividade';

    protected $primaryKey = 'id_log_atividade';

    protected $fillable = [
        'id_log_atividade',
        'url',
        'metodo',
        'ip',
        'fonte',
        'dados',
        'created_at',
        'updated_at',
        'inscr_cpf_autor_operacao',
        'inscr_cpf_administrador',
        'dt_hr_operacao',
        'desc_dado_manipulado',
        'vlr_dado_manipulado_de',
        'vlr_dado_manipulado_para',
        'acao',
        'id_usuario'
	];

    public function usuario() {
    	return $this->belongsTo('App\User','id_usuario');
    }
}
