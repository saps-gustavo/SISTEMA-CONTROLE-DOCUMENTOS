<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoServico extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'tipo_servico';

	protected $primaryKey = 'cod_tipo_servico';

    protected $fillable = [
        'desc_tipo_servico',
        'uniqid',
		'created_at',
		'updated_at'
	];

    public function TermoAdministrativo()
    {
        return $this->hasMany('App\Models\TermoAdministrativo');
    }
    
}