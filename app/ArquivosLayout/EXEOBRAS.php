<?php
namespace App\ArquivosLayout;

use App\Arquivo;
use App\Layout;
use App\ModelMPK;

class EXEOBRAS extends ModelMPK
{
	use CSVHandler;
	//use DesabilitarEventDispatcher;

    protected $connection = 'pgsqlsicom';

    protected $table = 'exeobras'; 

    protected $primaryKey = [
        'exercicio',
        'mes',        
        'tiporegistro',
        'codorgao',
        'codunidadesub',
        'nrocontrato',
        'exerciciocontrato'
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
        'codobra',       
        'objeto',
        'linkobra',
        'exerciciolicitacao',
        'nroprocessolicitatorio',
        'nrolote',
        'codunidadesubresp',
        'contdeclicitacao'
    ];

    /**
     * Retorna o arquivo CSV conforme o padrão definido no layout do SICOM.
     */

    public static function obterCSV($ano, $mes, $orgao)
    {

        try{

            $csv = '';

            // Detalhamento 10

            $ops = EXEOBRAS::where('exercicio', '=', $ano)
                            ->where('mes', '=', $mes)
                            ->where('codorgao', '=', $orgao)
                            ->get();

            if ($ops != null && $ops->count() > 0) {
                $arquivoOPS = Arquivo::where('nome_arquivo', 'EXEOBRAS')->first();
                $camposLayout = Layout::obter($ano, $arquivoOPS->id_arquivo, $ops[0]->tiporegistro);
                foreach ($ops as $opsItem) {

                    $opsItem['codorgao'] = '0'.$opsItem['codorgao'];

                    if($opsItem['nrolote'] == 0){
                        $opsItem['nrolote'] = '';
                    }
                    $csv .= self::formatarLinhaConformeLayout($camposLayout, $opsItem);              
                }    
            }

            // Detalhamento 20

            $ops = EXEOBRASDISPENSA::where('exercicio', '=', $ano)
                                    ->where('mes', '=', $mes)
                                    ->where('codorgao', '=', $orgao)
                                    ->get();

            if ($ops != null && $ops->count() > 0) {
                $arquivoOPS = Arquivo::where('nome_arquivo', 'EXEOBRAS')->first();
                $camposLayout = Layout::obter($ano, $arquivoOPS->id_arquivo, $ops[0]->tiporegistro);
                foreach ($ops as $opsItem) {

                    $opsItem['codorgao'] = '0'.$opsItem['codorgao'];

                    $csv .= self::formatarLinhaConformeLayout($camposLayout, $opsItem);              
                }    
            }

            return empty($csv) ? '99' : $csv;
        
        }
        catch(QueryException $e)
        {
            $msg = str_replace("\n", "", queryExceptionMessage($e));
            \Session::flash('mensagem',['msg'=>$msg]);
            return "ERRO:".$msg;
        }
        catch(\Exception $e)
        {
            $msg = str_replace("\n", "", $e->getMessage());
            \Session::flash('mensagem',['msg'=>$msg]);
            return "ERRO:".$msg;
        }

    }
}
