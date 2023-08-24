<?php
namespace App\ArquivosLayout;

use App\Arquivo;
use App\Layout;
use App\ModelMPK;

class EXEOBRASDISPENSA extends ModelMPK
{
	use CSVHandler;
	//use DesabilitarEventDispatcher;

    protected $connection = 'pgsqlsicom';

    protected $table = 'exeobras_dispensa'; 

    protected $primaryKey = [
        'exercicio',
        'mes',        
        'tiporegistro',
        'codorgao',
        'codunidadesub',
        'nrocontrato',
        'exerciciocontrato',
        'exercicioprocesso',
        'nroprocesso',
		'tipoprocesso'
    ];

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'exercicio',
        'mes',
		'tiporegistro',
		'codorgao',
		'codunidadesub',
		'nrocontrato',
		'exerciciocontrato',
		'exercicioprocesso',
		'nroprocesso',
		'tipoprocesso',
		'codobra',
		'objeto',
		'linkobra',
        'codunidadesubresp',
        'contdeclicitacao'
    ];
}
