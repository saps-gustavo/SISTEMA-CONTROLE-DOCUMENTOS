<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SituacaoTermoAdministrativo extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'situacao_termo_adm';

	protected $primaryKey = 'cod_situacao';

    protected $fillable = [
        'desc_situacao',
        'uniqid',
		'created_at',
		'updated_at'
	];


    public function TermoAdministrativo()
    {
        return $this->hasMany('App\Models\TermoAdministrativo');
    }
}