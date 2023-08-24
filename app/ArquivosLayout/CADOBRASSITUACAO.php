<?php
namespace App\ArquivosLayout;

use App\Arquivo;
use App\Layout;
use App\ModelMPK;

class CADOBRASSITUACAO extends ModelMPK
{
	use CSVHandler;
	//use DesabilitarEventDispatcher;

    protected $connection = 'pgsqlsicom';

    protected $table = 'cadobras_situacao'; 

    protected $primaryKey = [
        'exercicio',
        'mes',        
        'tiporegistro',
        'codobra'
    ];

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'exercicio',
        'mes',        
        'tiporegistro',
        'codobra',
        'situacaoobra',
        'datasituacaoobra',
        'veiculopublicacao',
        'datapublicveiculo',
        'dscsituacaoobra',
        'codorgao'
    ];

}
