<?php
namespace App\ArquivosLayout;

use App\Arquivo;
use App\Layout;
use App\ModelMPK;

class CADOBRASSITUACAOPARALISACAO extends ModelMPK
{
    protected $connection = 'pgsqlsicom';

    protected $table = 'cadobras_situacao_paralisacao';

	protected $primaryKey = 'id_cadobras_situacao';

	public $incrementing = false;

    protected $fillable = [
		'id_cadobras_situacao',
        'exercicio',
        'mes',
		'tiporegistro',
		'codobra',
		'datasituacaoobra',
		'motivoparalisacao',
		'dscoutrosparalisacao',
		//'numprocesso',
		//'orgaojudiciario',
		'dataretomada',
		'codorgao'
	];
	
	public function cadobras() {
        return $this->hasMany('App\CADOBRASSITUACAO');
	}

	public function motivo() {
        return $this->belongsTo('App\MotivoParalisacao', 'cod_motivo_paralisacao', 'motivoparalisacao');
	}

}

