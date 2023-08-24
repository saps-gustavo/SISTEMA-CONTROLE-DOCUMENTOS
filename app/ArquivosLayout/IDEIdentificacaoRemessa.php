<?php
namespace App\ArquivosLayout;

use App\ModelMPK;

use App\vwSequenciaMaximaPorPeriodo;
use App\OrgaoTCE;

class IDEIdentificacaoRemessa extends ModelMPK
{
	use CSVHandler;
	use DesabilitarEventDispatcher;

    const COD_MUNICIPIO = '01756';

    //const CNPJ_MUNICIPIO = '18338178000102';

    /**
     * Retorna o arquivo CSV conforme o padrão definido no layout do SICOM.
     */
    public static function obterCSV($ano, $mes, $orgao, $id_arquivo_modulo)
    {
        $tipoOrgao = self::verificarTipoOrgao($orgao);

        $orgao_emissor = OrgaoTCE::where('cod_orgao_tce', '=', (int)$orgao)->first();

        switch ($id_arquivo_modulo) {
            case 1: // Edital
                $seq = vwSequenciaMaximaPorPeriodo::UltimaSequenciaRALICREDISPI($ano, $mes, str_pad((int)$orgao,2,'0',STR_PAD_LEFT));
                $csv =  self::COD_MUNICIPIO.';'.$orgao_emissor->cnpj.';'.$orgao.';'.$tipoOrgao.';'.$ano.';'.$mes.';'.date('dmY').'; ; '.str_pad($seq,3,'0',STR_PAD_LEFT).';';
                break;
            case 2: // Obras
                $csv =  self::COD_MUNICIPIO.';'.$orgao_emissor->cnpj.';'.$orgao.';'.$tipoOrgao.';'.$ano.';'.$mes.';'.date('dmY').'; ;';
                break;
        }
        
        return empty($csv) ? '99' : $csv;
    }
    
    public static function verificarTipoOrgao($orgao)
    {        
        switch ($orgao) {
            case 1: //Câmara Municipal
            case 2: //Prefeitura
                return "02";
                break;           
            case 3: //Agenda
                return "03";//Autarquia
                break;
            case 4: //Mapro
                return $orgao;
                break;
            case 5: //Procon
                return "03";//Autarquia
                break;
            case 6: //Funalfa
                return "04"; //Fundação
                break;
            case 7: //Demlurb
                return "03"; //Autarquia
                break;
            case 8: //RPPS
                return "05"; //RPPS
                break;
           
        }        
    
    }
    
}
