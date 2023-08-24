<?php
namespace App\ArquivosLayout;

use App\Arquivo;
use App\Layout;
use App\ModelMPK;
use App\REDISPILOCALIZACAO;
use App\REDISPIOBRAS;
use App\vwSequenciaMaximaPorPeriodo;

class REDISPI extends ModelMPK
{
	use CSVHandler;
	//use DesabilitarEventDispatcher;

    protected $connection = 'pgsqlsicom';

    protected $table = 'redispi';

	protected $primaryKey = 'id_redispi';

    protected $fillable = [
        'exercicio',
        'mes',
		'tiporegistro',
		'codorgaoresp',
		'codunidadesubresp',
		'codunidadesubrespestadual',
		'exercicioprocesso',
		'nroprocesso',
		'tipoprocesso',
		'tipocadastrodispensainexigibilidade',
		'dsccadastrolicitatorio',
		'dtabertura',
		'naturezaobjeto',
		'objeto',
		'justificativa',
		'razao',
		'vlrecurso',
		'dbi',
        'link',
        'leilicitacao',
		'regimeexecucaoobras',
		'create_at',
		'updated_at'
	];
	
	public function FKTipoCadastroDispensaInexigibilidade() {
        return $this->belongsTo('App\TipoCadastroLicitacao', 'tipocadastrodispensainexigibilidade', 'cod_tipo_cadastro_licitacao');
	}

	public function FKNaturezaObjeto() {
        return $this->belongsTo('App\NaturezaObjeto', 'naturezaobjeto', 'cod_natureza_objeto');
	}

	public function FKTipoProcesso() {
        return $this->belongsTo('App\TipoProcesso', 'tipoprocesso', 'cod_tipo_processo');
	}

    /**
     * Retorna o arquivo CSV conforme o padrão definido no layout do SICOM.
     */

    public static function obterCSV($ano, $mes, $orgao)
    {

        try{

            $csv = '';

            $seq = vwSequenciaMaximaPorPeriodo::UltimaSequenciaRALICREDISPI($ano, $mes, str_pad($orgao,2,'0',STR_PAD_LEFT));

            $nro_mestre = 1; // primeiro incremento vai somar 1 e começar com 002 (layout)
            $nro_detalhe = 0; // primeiro incremento vai somar 1 e começar com 001 (layout)

            $tem_detalhe = false;

            $redispi = REDISPI::where('exercicio', '=', $ano)
                            ->where('mes', '=', $mes)
                            ->where('codorgaoresp', '=', $orgao)
                            ->where('sequencia', '=', $seq)
                            ->get();
            
            // Detalhamento 10
            if ($redispi != null && $redispi->count() > 0) {

                $arquivo = Arquivo::where('nome_arquivo', 'REDISPI')->first();
                $camposLayout = Layout::obter($ano, $arquivo->id_arquivo, $redispi[0]->tiporegistro);

                foreach ($redispi as $item) {

                    $item['codorgaoresp'] = '0'.$item['codorgaoresp'];    
                    
                    // Detalhamento 11
                    $redispiobras = REDISPIOBRAS::where('id_redispi', '=', $item['id_redispi'])->get();

                    if ($redispiobras != null && $redispiobras->count() > 0) {

                        // soma um no MESTRE antes de escrever
                        $nro_mestre = $nro_mestre + 1;

                        // Soma um no detalhes antes de escrever
                        $nro_detalhe = $nro_detalhe + 1;

                        // Informo que tem detalhe para o registro 12
                        $tem_detalhe = true;

                        // Escrevo o CSV com o registro MESTRE
                        //$csv .= self::formatarLinhaConformeLayout($camposLayout, $item, str_pad($nro_mestre,3,'0',STR_PAD_LEFT));
                        $csv .= self::formatarLinhaConformeLayout($camposLayout, $item);

                        $camposLayoutObras = Layout::obter($ano, $arquivo->id_arquivo, $redispiobras[0]->tiporegistro);

                        foreach ($redispiobras as $itemobras) {

                            $itemobras['codorgaoresp'] = '0'.$itemobras['codorgaoresp'];

                            $itemobras['codbempublico'] = str_pad($itemobras['codbempublico'],4,'0',STR_PAD_LEFT);

                            //$csv .= self::formatarLinhaConformeLayout($camposLayoutObras, $itemobras, str_pad($nro_detalhe,3,'0',STR_PAD_LEFT));              
                            $csv .= self::formatarLinhaConformeLayout($camposLayoutObras, $itemobras);              
                        }
                    }

                    // Detalhamento 12
                    $redispilocalizacao = REDISPILOCALIZACAO::where('id_redispi', '=', $item['id_redispi'])->get();

                    if ($redispilocalizacao != null && $redispilocalizacao->count() > 0) {

                        if ($tem_detalhe == false){
                            // Ainda não escreveu o registro 10 nem o 11, pois não entrou no IF acima

                            // soma um no MESTRE antes de escrever
                            $nro_mestre = $nro_mestre + 1;

                            // Soma um no detalhes antes de escrever
                            $nro_detalhe = $nro_detalhe + 1;

                            // Informo que tem detalhe para o registro 12
                            $tem_detalhe = true;

                            // Escrevo o CSV com o registro MESTRE
                            //$csv .= self::formatarLinhaConformeLayout($camposLayout, $item, str_pad($nro_mestre,3,'0',STR_PAD_LEFT));
                            $csv .= self::formatarLinhaConformeLayout($camposLayout, $item);
                        }

                        $camposLayoutLocalizacao = Layout::obter($ano, $arquivo->id_arquivo, $redispilocalizacao[0]->tiporegistro);

                        foreach ($redispilocalizacao as $itemlocalizacao) {

                            $itemlocalizacao['codorgaoresp'] = '0'.$itemlocalizacao['codorgaoresp'];

                            //$csv .= self::formatarLinhaConformeLayout($camposLayoutLocalizacao, $itemlocalizacao, str_pad($nro_detalhe,3,'0',STR_PAD_LEFT));              
                            $csv .= self::formatarLinhaConformeLayout($camposLayoutLocalizacao, $itemlocalizacao, null, 6);              
                        }
                    }

                    if($tem_detalhe == false){
                        // Escrevo o CSV sem o registro MESTRE
                        // Escrevo no final pois como não tem detalhe, não foi escrito em nenhuma das etapas acima (11 e 12)
                        $csv .= self::formatarLinhaConformeLayout($camposLayout, $item);
                    }else{
                        // Seto para FALSE para o próximo LOOP
                        $tem_detalhe == false;
                    }

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
