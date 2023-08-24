<?php

namespace App\ArquivosLayout;

use App\Utilitarios;
use Carbon\Carbon;
use App\Layout;

/**
 * Contém métodos utilitários para formatar dados do banco de dados
 * no formato CSV.
 */
trait CSVHandler
{
	/**
	 * Retornar o dado formatado (delimitador, decimal, etc.) conforme
	 * definido no modelo App\Layout.
	 */
	private static function formatarLinhaConformeLayout($camposLayout, $dados, $complemento = null, $formatacao = 2) {
		$csv = '';
		
		foreach ($camposLayout as $itemLayout) {
			$csv .= self::fmtCampo($dados, $itemLayout, ";", $formatacao);
		}
		
        if(isset($complemento)){ // Enviou um complemento para ser adicionado ao final da linha
            $csv .= $complemento.";";
        }

		return empty($csv) ? $csv : (rtrim($csv, ';') . "\n");
	}

    /**
     * Formata campo conforme layout do sicom:
     * - Espaço em branco caso não exista valor
     * - Utilizar ',' e não '.' em valores com precisão decimal
     */
    private static function fmtCampo($item, $layout, $demilitador = ';', $formatacao = 2)
    {   
        $dado = $item->{$layout->nome_campo};      
        
        $retorno = trim($dado);
        
        if(isset($retorno) && $retorno != "") {
            switch ($layout->tipo)
            {
                case Layout::DOUBLE: 
                    $retorno = number_format($dado, $formatacao, ',', '');
                    break;                
                case Layout::DATE:
                    $dataBD =  \DateTime::createFromFormat("Y-m-d", $dado);                    
                    $retorno = $dataBD->format('dmY');                
                    break; 
            }
        } else {
            $retorno = ' ';
        }
        
        $retorno .= $demilitador;
        
        return $retorno;
    }
}
