<?php
namespace App\ArquivosLayout;

use App\Arquivo;
use App\Layout;
use App\ModelMPK;
use App\RALICLOCALIZACAO;
use App\RALICOBRAS;
use App\vwSequenciaMaximaPorPeriodo;

class RALIC extends ModelMPK
{
	use CSVHandler;
	//use DesabilitarEventDispatcher;

    protected $connection = 'pgsqlsicom';

    protected $table = 'ralic';

	protected $primaryKey = 'id_ralic';

    protected $fillable = [
        'exercicio',
        'mes',
		'tiporegistro',
		'codorgaoresp',
		'codunidadesubresp',
		'codunidadesubrespestadual',
		'exerciciolicitacao',
		'nroprocessolicitatorio',
		'tipocadastrolicitacao',
		'dsccadastrolicitatorio',
		'codmodalidadelicitacao',
		'naturezaprocedimento',
		'nroedital',
		'exercicioedital',
		'dtpublicacaoeditaldo',
		'link',
		'criteriojulgamento',
		'naturezaobjeto',
		'objeto',
		'regimeexecucaoobras',
		'vlcontratacao',
		'dbi',
		'mesexercicioreforc',
		'origemrecurso',
		'dscorigemrecurso',
        'qtdlotes',
        'leilicitacao',
		'mododisputa',
		'create_at',
		'updated_at'
	];
	
	public function FKTipoCadastroLicitacao() {
        return $this->belongsTo('App\TipoCadastroLicitacao', 'tipocadastrolicitacao', 'cod_tipo_cadastro_licitacao');
	}

	public function FKModalidadeLicitacao() {
        return $this->belongsTo('App\ModalidadeLicitacao', 'codmodalidadelicitacao', 'cod_modalidade_licitacao');
	}

	public function FKNaturezaProcedimento() {
        return $this->belongsTo('App\NaturezaProcedimento', 'naturezaprocedimento', 'cod_natureza_procedimento');
	}

	public function FKTipoLicitacao() {
        return $this->belongsTo('App\TipoLicitacao', 'tipolicitacao', 'cod_tipo_licitacao');
	}

	public function FKNaturezaObjeto() {
        return $this->belongsTo('App\NaturezaObjeto', 'naturezaobjeto', 'cod_natureza_objeto');
	}

	public function FKRegimeExecucaoObras() {
        return $this->belongsTo('App\RegimeExecucaoObras', 'regimeexecucaoobras', 'cod_regime_execucao_obras');
	}

	public function FKOrigemRecurso() {
        return $this->belongsTo('App\OrigemRecurso', 'origemrecurso', 'cod_origem_recurso');
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

            $ralic = RALIC::where('exercicio', '=', $ano)
                            ->where('mes', '=', $mes)
                            ->where('codorgaoresp', '=', str_pad($orgao,2,'0',STR_PAD_LEFT))  
                            ->where('sequencia', '=', $seq)
                            ->get();
            
            // Detalhamento 10
            if ($ralic != null && $ralic->count() > 0) {

                $arquivo = Arquivo::where('nome_arquivo', 'RALIC')->first();
                $camposLayout = Layout::obter($ano, $arquivo->id_arquivo, $ralic[0]->tiporegistro);

                // separar PDFs da Vez

                foreach ($ralic as $item) {

                    $item['codorgaoresp'] = '0'.$item['codorgaoresp'];                      
                    $item['codmodalidadelicitacao'] = '0'.$item['codmodalidadelicitacao'];
                    
                    // Detalhamento 11
                    $ralicobras = RALICOBRAS::where('id_ralic', '=', $item['id_ralic'])->get();

                    if ($ralicobras != null && $ralicobras->count() > 0) {

                        // soma um no MESTRE antes de escrever
                        $nro_mestre = $nro_mestre + 1;

                        // Soma um no detalhes antes de escrever
                        $nro_detalhe = $nro_detalhe + 1;

                        // Informo que tem detalhe para o registro 12
                        $tem_detalhe = true;

                        // Escrevo o CSV com o registro MESTRE
                        //$csv .= self::formatarLinhaConformeLayout($camposLayout, $item, str_pad($nro_mestre,3,'0',STR_PAD_LEFT));
                        $csv .= self::formatarLinhaConformeLayout($camposLayout, $item);

                        $camposLayoutObras = Layout::obter($ano, $arquivo->id_arquivo, $ralicobras[0]->tiporegistro);

                        foreach ($ralicobras as $itemobras) {

                            $itemobras['codorgaoresp'] = '0'.$itemobras['codorgaoresp'];

                            $itemobras['codbempublico'] = str_pad($itemobras['codbempublico'],4,'0',STR_PAD_LEFT);

                            //$csv .= self::formatarLinhaConformeLayout($camposLayoutObras, $itemobras, str_pad($nro_detalhe,3,'0',STR_PAD_LEFT));              
                            $csv .= self::formatarLinhaConformeLayout($camposLayoutObras, $itemobras);              
                        }
                    }

                    // Detalhamento 12
                    $raliclocalizacao = RALICLOCALIZACAO::where('id_ralic', '=', $item['id_ralic'])->get();

                    if ($raliclocalizacao != null && $raliclocalizacao->count() > 0) {

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

                        $camposLayoutLocalizacao = Layout::obter($ano, $arquivo->id_arquivo, $raliclocalizacao[0]->tiporegistro);

                        foreach ($raliclocalizacao as $itemlocalizacao) {
                            
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
