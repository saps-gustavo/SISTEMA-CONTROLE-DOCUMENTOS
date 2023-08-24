<?php
namespace App\ArquivosLayout;

use App\Arquivo;
use App\Layout;
use App\ModelMPK;

class PESSOA extends ModelMPK
{
	use CSVHandler;
    //use DesabilitarEventDispatcher;
    
    protected $connection = 'pgsqlsicom';

    protected $table = 'pessoa';

	protected $primaryKey = 'id_pessoa';

    protected $fillable = [
		'exercicio',
		'mes',
		'tiporegistro',
		'nrodocumento',
		'nomepessoafisica',
		'tipocadastro',
        'justificativaalteracao',
        'codorgao'
	];
/*
    protected $connection = 'pgsqlsicom';

    protected $table = 'pessoa2';

    protected $primaryKey = [
        'exercicio',
        'mes',        
        'nrodocumento'
    ];

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'exercicio',
        'mes',
        'tiporegistro',
        'tipodocumento',
        'nrodocumento',
        'nomerazaosocial',
        'tipocadastro',
        'justificativaalteracao',
        'dt_dimcadastro'
	];
  */  
    //const DIA_FECHAMENTO = 20;

    /**
     * Retorna o arquivo CSV conforme o padrão definido no layout do SICOM.
     */
    public static function obterCSV($ano, $mes, $orgao)
    {
        //$diaPosFechamento = new \DateTime("$ano-$mes-".self::DIA_FECHAMENTO);
        //$diaPosFechamento->add(new \DateInterval('P1D'));
        
        //$mesPosterior = new \DateTime("$ano-$mes-".self::DIA_FECHAMENTO);
        //$mesPosterior->add(new \DateInterval('P1M'));
        
        try{

            $csv = '';
            $pessoa = PESSOA::where('exercicio', '=', $ano)
                ->where('mes', '=', $mes)
                ->where('codorgao', '=', $orgao)
                //->whereNull('dt_dimcadastro') //dados oriundos do siafem
                //->orWhere('dt_dimcadastro', '>=', $diaPosFechamento->format('Y-m-d')) //dados oriundos do dimcadastro
            // ->where('dt_dimcadastro', '<=', $mesPosterior->format('Y-m-d')) //dados oriundos do dimcadastro
                ->get();

            if ($pessoa != null && $pessoa->count() > 0) {
                $arquivoPessoa = Arquivo::where('nome_arquivo', 'PESSOA')->first();
                $camposLayout = Layout::obter($ano, $arquivoPessoa->id_arquivo, $pessoa[0]->tiporegistro);

                foreach ($pessoa as $pessoaItem) {
                    $csv .= self::formatarLinhaConformeLayout($camposLayout, $pessoaItem);
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
