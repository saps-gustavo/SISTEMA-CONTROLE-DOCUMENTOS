<?php
namespace App\ArquivosLayout;

use App\Arquivo;
use App\Layout;
use App\ModelMPK;

class CADOBRAS extends ModelMPK
{
	use CSVHandler;
	//use DesabilitarEventDispatcher;

    protected $connection = 'pgsqlsicom';

    protected $table = 'cadobras'; 

    protected $primaryKey = 'id_cadobras';

    protected $fillable = [
        'exercicio',
        'mes',
		'tiporegistro',
		'codobra',
		'codorgao',
		'tiporesponsavel',
		'tiporegistroconselhoprofissional',
		'nroregistroconselhoprofissional',
		'nrort',
		'dtinicioatividadeengenheiro',
		'tipovinculo',
		'nrodocumento',
        'dscoutroconselho'
	];

    /**
     * Retorna o arquivo CSV conforme o padrão definido no layout do SICOM.
     */

    public static function obterCSV($ano, $mes, $orgao)
    {
        try
		{
            $csv = '';

            // Detalhamento 10
            
            $ops = CADOBRAS::where('exercicio', '=', $ano)
                            ->where('mes', '=', $mes)
                            ->where('codorgao', '=', $orgao)
                            ->get();

            $arquivo = Arquivo::where('nome_arquivo', 'CADOBRAS')->first();

            if ($ops != null && $ops->count() > 0) {

                $camposLayout = Layout::obter($ano, $arquivo->id_arquivo, $ops[0]->tiporegistro);

                foreach ($ops as $opsItem) {
                    //dd($opsItem);
                    $opsItem['codorgao'] = '0'.$opsItem['codorgao'];

                    $csv .= self::formatarLinhaConformeLayout($camposLayout, $opsItem);              
                }    
            }

            // Detalhamento 20

            $nro_mestre = 1; // primeiro incremento vai somar 1 e começar com 002 (layout)
            $nro_detalhe = 0; // primeiro incremento vai somar 1 e começar com 001 (layout)

            $ops = CADOBRASSITUACAO::where('exercicio', '=', $ano)
                                    ->where('mes', '=', $mes)
                                    ->where('codorgao', '=', $orgao)
                                    ->get();

            if ($ops != null && $ops->count() > 0) {

                $camposLayout = Layout::obter($ano, $arquivo->id_arquivo, $ops[0]->tiporegistro);

                foreach ($ops as $opsItem) {

                    $opsItem['codorgao'] = '0'.$opsItem['codorgao'];           
                    
                    // Detalhamento 21
                    
                    $opsParalisacao = CADOBRASSITUACAOPARALISACAO::where('id_cadobras_situacao', '=', $opsItem['id_cadobras_situacao'])->get();

                    if ($opsParalisacao != null && $opsParalisacao->count() > 0) {

                        // soma um no MESTRE antes de escrever
                        $nro_mestre = $nro_mestre + 1;

                        // Soma um no detalhes antes de escrever
                        $nro_detalhe = $nro_detalhe + 1;

                        // Escrevo o CSV com o registro MESTRE
                        //$csv .= self::formatarLinhaConformeLayout($camposLayout, $opsItem, str_pad($nro_mestre,3,'0',STR_PAD_LEFT));
                        $csv .= self::formatarLinhaConformeLayout($camposLayout, $opsItem);

                        $camposLayoutParalisacao = Layout::obter($ano, $arquivo->id_arquivo, $opsParalisacao[0]->tiporegistro);

                        foreach ($opsParalisacao as $opsItemParalisacao) {

                            $opsItemParalisacao['codorgao'] = '0'.$opsItemParalisacao['codorgao'];
                            $opsItemParalisacao['motivoparalisacao'] = '0'.$opsItemParalisacao['motivoparalisacao'];

                            //$csv .= self::formatarLinhaConformeLayout($camposLayoutParalisacao, $opsItemParalisacao,str_pad($nro_detalhe,3,'0',STR_PAD_LEFT));              
                            $csv .= self::formatarLinhaConformeLayout($camposLayoutParalisacao, $opsItemParalisacao);              
                        }
                    }else{
                        // Escrevo o CSV sem o registro MESTRE
                        $csv .= self::formatarLinhaConformeLayout($camposLayout, $opsItem);
                    }

                }    
            }

            // Detalhamento 30

            $ops = CADOBRASMEDICAO::where('exercicio', '=', $ano)
                                        ->where('mes', '=', $mes)
                                        ->where('codorgao', '=', $orgao)
                                        ->get();
            
            if ($ops != null && $ops->count() > 0) {
                
                $camposLayout = Layout::obter($ano, $arquivo->id_arquivo, $ops[0]->tiporegistro);

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
