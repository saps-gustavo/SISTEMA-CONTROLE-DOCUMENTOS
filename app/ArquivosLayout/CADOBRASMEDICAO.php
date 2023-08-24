<?php
namespace App\ArquivosLayout;

use App\Arquivo;
use App\Layout;
use App\ModelMPK;

class CADOBRASMEDICAO extends ModelMPK
{
	use CSVHandler;
	//use DesabilitarEventDispatcher;

    protected $connection = 'pgsqlsicom';

    protected $table = 'cadobras_medicao'; 

    protected $primaryKey = [
        'exercicio',
        'mes',        
        'tiporegistro',
        'codobra',
        'tipomedicao',
        'nummedicao'
    ];

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'exercicio',
        'mes',        
        'tiporegistro',
        'codobra',
        'codorgao',
        'tipomedicao',
        'desctipomedicaooutros',
        'nummedicao',
        'dscmedicao',
        'datamedicaode',
        'datamedicaoate',
        'datamedicao',
        'vlmedicao'
    ];

}
